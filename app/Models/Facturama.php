<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;

class Facturama
{
  public function createInvoice($params)
  {
    return (Object) $this->getClient()->post("https://apisandbox.facturama.mx/3/cfdis", $params)->json();
  }

  public function downloadInvoice($facturaId)
  { 
    return (Object) $this->getClient()->get("https://apisandbox.facturama.mx/cfdi/pdf/issued/{$facturaId}")->json();
  }

  private function getClient()
  {
    return Http::withBasicAuth(env('FACTURAMA_USER'), env('FACTURAMA_PASSWORD'));
  }
}