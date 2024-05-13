<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" >
        <x-app.navbar />

        <div id ="calendar" style="margin: 20px"></div>
        <x-app.footer />
    </main>

</x-app-layout>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarID = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarID, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            initialDate: '<?=date('Y-m-d')?>',
            navLinks: true,
            editable: false,
        });
        calendar.render();
    });
</script>
