<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\NoticeInvoiceCreated;
use App\Mail\SendInvoice;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'api_response' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function scopeActives($query)
    {
        return $query->whereNotNull('api_response');
    }

    public function getTotal()
    {
        return $this->orderDetails->reduce(function ($carry, $item) {
            return $carry + $item->price;
        }, 0);
    }

    public function hasInvoice()
    {
        return ! is_null($this->facturama_id);
    }

    public function downloadInvoice()
    {
        Mail::to($this->user)->send(new SendInvoice($this->user, $this));
        if ($this->pdf_file) {
            return $this->pdf_file;
        }
    
        $facturama = new Facturama;

        $response = $facturama->downloadInvoice($this->facturama_id);

        $path = "public/invoice/{$this->id}.pdf";

        Storage::put($path, base64_decode($response->Content));

        $this->update(['pdf_file' => $path]);
        
        return $path;
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->uuid = str()->uuid();
        });

        static::updating(function (Order $order) {
            if ($order->isDirty('facturama_id')) {
                Mail::to($order->user)->send(new NoticeInvoiceCreated($order->user));
            }
        });
    }
}
