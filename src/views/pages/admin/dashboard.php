<style>
    .stat-card-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); }
    .stat-card .icon {
        font-size: 2em;
        margin-right: 15px;
        width: 60px; height: 60px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        color: white;
    }
    .stat-card .icon.users { background: #007bff; }
    .stat-card .icon.spots { background: #28a745; }
    .stat-card .icon.products { background: #ffc107; }
    .stat-card .icon.feedback { background: #dc3545; }
    
    .stat-card .info h3 { margin: 0; font-size: 1.8em; color: #333; }
    .stat-card .info p { margin: 0; font-size: 0.9em; color: #777; font-weight: 600; }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .dashboard-box {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .dashboard-box h3 { margin-top: 0; color: #003366; border-bottom: 2px solid #f0f2f5; padding-bottom: 10px; margin-bottom: 15px; }

    #calendar { max-height: 500px; }
    .fc-toolbar-title { font-size: 1.2em !important; }
    .fc-button { font-size: 0.8em !important; }

    @media (max-width: 1024px) {
        .dashboard-grid { grid-template-columns: 1fr; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<h2>Admin Dashboard</h2>

<div class="stat-card-container">
    <div class="stat-card">
        <div class="icon users"><i class="fa fa-users"></i></div>
        <div class="info">
            <h3><?php echo htmlspecialchars($stats['users'] ?? 0); ?></h3>
            <p>Tourists</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon spots"><i class="fa fa-map-location-dot"></i></div>
        <div class="info">
            <h3><?php echo htmlspecialchars($stats['spots'] ?? 0); ?></h3>
            <p>Spots</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon products"><i class="fa fa-utensils"></i></div>
        <div class="info">
            <h3><?php echo htmlspecialchars($stats['products'] ?? 0); ?></h3>
            <p>Products</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon feedback"><i class="fa fa-comments"></i></div>
        <div class="info">
            <h3><?php echo htmlspecialchars($stats['pending_feedback'] ?? 0); ?></h3>
            <p>Feedback</p>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    
    <div class="dashboard-box">
        <h3>Overview Statistics</h3>
        <canvas id="myChart"></canvas>
    </div>

    <div class="dashboard-box">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
            <h3 style="margin:0; border:none;">Event Calendar</h3>
            <small style="color:#777;">(Click date to add event)</small>
        </div>
        <div id="calendar"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    

    const ctx = document.getElementById('myChart');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Registered Users', 'Tourist Spots', 'Products', 'Pending Feedback'],
            datasets: [{
                label: 'System Data',
                data: [
                    <?php echo $stats['users']; ?>, 
                    <?php echo $stats['spots']; ?>, 
                    <?php echo $stats['products']; ?>, 
                    <?php echo $stats['pending_feedback']; ?>
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(40, 167, 69, 0.7)', 
                    'rgba(255, 193, 7, 0.7)', 
                    'rgba(220, 53, 69, 0.7)'  
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });


    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        height: 450,
        
    
        dateClick: function(info) {
        
        
        
            if(confirm('Do you want to add an event on ' + info.dateStr + '?')) {
                window.location.href = 'index.php?page=admin_add_event';
            }
        },

    
        events: [
            <?php foreach ($events as $evt): ?>
            {
                title: '<?php echo addslashes($evt['event_name']); ?>',
                start: '<?php echo $evt['start_date']; ?>',
                <?php if (!empty($evt['end_date'])): ?>
                end: '<?php echo $evt['end_date']; ?>',
                <?php endif; ?>
                url: 'index.php?page=admin_edit_event&id=<?php echo $evt['id']; ?>',
                color: '#003366'
            },
            <?php endforeach; ?>
        ]
    });
    calendar.render();
});
</script>