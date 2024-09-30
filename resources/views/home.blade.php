@php
use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('content')
    <div>
        <div class="container">
            <div class="row justify-content-center">
                @session('success')
                <div class="alert alert-primary" role="alert">
                    {{ $value }}
                </div>
                @endsession
                @session('error')
                <div class="alert alert-danger" role="alert">
                    {{ $value }}
                </div>
                @endsession
                <div class="col-md-9">
                    <div class="row">

                        <h3>Calendario de Asistencias al Trabajo</h3>

                        <button class="btn btn-primary" id="new-assignment">Nueva Asignación</button>
                        <hr />
                        <div>
                            <button class="btn btn-warning" id="previous-month">Anterior</button>
                            <b><span id="current-month">{{ $currentMonth }}</span></b>
                            <button class="btn btn-success" id="next-month">Siguiente</button>
                        </div>
                        <hr />

                        <table class="table table-bordered" style="width: 100%">
                            <thead>
                                <tr>
                                    @foreach ($daysOfWeek as $day)
                                        <th>{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody id="calendar-body">
                                @foreach ($calendarWeeks as $week)
                                    <tr>
                                        @foreach ($week as $day)
                                            <td class="calendar-cell" data-date="{{ $day->format('Y-m-d') }}"
                                                style="text-align:center">
                                                @if ($day->month == $currentDate->month)
                                                    <b>{{ $day->day }}</b>
                                                    @foreach ($workplacesshedule as $userSchedule)
                                                    @if (Carbon::parse($userSchedule->shedule)->toDateString() == $day->toDateString())
                                                            @foreach ($users as $user)
                                                                @if ($user->id == $userSchedule->userid)
                                                                    <div>{{ $user->name }}</div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="modal" tabindex="-1" role="dialog" style="display:none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Agregar Horario de Asistencia</h5>
                                        <button type="button" class="close" id="close-modal">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="schedule-form" method="POST"
                                            action="{{ route('workplaceschedules.store') }}">
                                            @csrf
                                            <input type="hidden" name="userid" id="userid" value="{{auth()->user()->userIdBase()}}" />
                                            <div class="mb-3">
                                                <label for="schedule" class="form-label">Fecha de
                                                    Asistencia</label>
                                                <input type="date" class="form-control" name="shedule"
                                                    id="shedule" required>
                                                @error('schedule_date')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                                <button type="button" class="btn btn-secondary"
                                                    id="close-modal">Cerrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $(document).ready(function() {
        const users = @json($users);
        const listadoUsuariosEspacio = @json($workplacesshedule);
        var currentDate = moment().startOf('month'); // Inicializar con el primer día del mes actual
        moment.updateLocale('en', {
            week: {
                dow: 1 // 0 = domingo
            }
        });

        // Navegar al mes anterior
        $('#previous-month').click(function() {
            currentDate.subtract(1, 'month');
            updateCalendar();
        });

        // Navegar al mes siguiente
        $('#next-month').click(function() {
            currentDate.add(1, 'month');
            updateCalendar();
        });

        // Mostrar la semana actual
        $('#show-current-week').click(function() {
            currentDate = moment(); // Regresar a la fecha actual
            updateCalendar();
        });

        // Seleccionar fecha
        $(document).on('click', '.calendar-cell', function() {
            let date = $(this).data('date');
            $('#shedule').val(date); // Coloca la fecha seleccionada en el input
            $('#new-assignment').trigger('click'); // Muestra el modal
        });

        // Mostrar el modal
        $('#new-assignment').click(function() {
            $('.modal').show();
        });

        // Cerrar el modal
        $(document).on('click', '#close-modal', function() {
            $('.modal').hide();
        });

        updateCalendar(); // Llamada inicial para mostrar el calendario

        function updateCalendar() {
            $('#current-month').text(currentDate.format('MMMM YYYY'));

            // Obtener el primer y último día del mes
            let startOfMonth = currentDate.clone().startOf('month');
            let endOfMonth = currentDate.clone().endOf('month');

            // Asegurarse de que la semana comience el domingo
            let startDate = startOfMonth.clone().startOf('week'); // Restar un día para que empiece en domingo
            let endDate = endOfMonth.clone().endOf('week');

            let calendarWeeks = [];
            let currentDay = startDate.clone();

            // Construir las semanas del calendario
            while (currentDay.isBefore(endDate, 'day')) {
                let week = [];
                for (let i = 0; i < 7; i++) {
                    week.push(currentDay.clone());
                    currentDay.add(1, 'day');
                }
                calendarWeeks.push(week);
            }

            // Limpiar el cuerpo de la tabla
            $('#calendar-body').empty();

            // Obtener los datos de los horarios y usuarios
            const workScheduleMap = {};
            listadoUsuariosEspacio.forEach(schedule => {
                const scheduleDate = moment(schedule.shedule).format('YYYY-MM-DD');
                if (!workScheduleMap[scheduleDate]) {
                    workScheduleMap[scheduleDate] = [];
                }
                const user = users.find(u => u.id === schedule.userid);
                if (user) {
                    workScheduleMap[scheduleDate].push(user.name);
                }
            });

            // Construir el HTML para cada semana y cada día
            calendarWeeks.forEach(week => {
                let row = $('<tr></tr>');
                week.forEach(day => {
                    let cell = $('<td></td>')
                        .addClass('calendar-cell')
                        .data('date', day.format('YYYY-MM-DD'))
                        .css('text-align', 'center');

                    if (day.month() === currentDate.month()) {
                        cell.html(`<b>${day.date()}</b>`);
                    } else {
                        cell.html(day.date()); // Muestra el día, pero sin resaltar
                    }

                    // Mostrar los usuarios si hay horarios para esa fecha
                    const dateKey = day.format('YYYY-MM-DD');
                    if (workScheduleMap[dateKey]) {
                        workScheduleMap[dateKey].forEach(userName => {
                            cell.append(`<div>${userName}</div>`);
                        });
                    }

                    row.append(cell);
                });
                $('#calendar-body').append(row);
            });
        }
    });
</script>