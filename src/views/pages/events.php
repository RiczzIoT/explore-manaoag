<style>
    .events-header {
        text-align: center;
        background-color: #003366; color: white;
        padding: 50px 20px; margin-bottom: 40px;
    }
    .events-header h2 { font-size: 3em; font-weight: 900; margin: 0; }

    .events-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px; max-width: 1100px; margin: 0 auto 60px; padding: 0 20px;
    }
    
    .event-card {
        background: white; border-radius: 15px; overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: transform 0.3s;
        display: flex; flex-direction: column; height: 100%;
    }
    .event-card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(0,0,0,0.15); }

    .event-img-box { position: relative; height: 200px; overflow: hidden; }
    .event-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .event-card:hover .event-img-box img { transform: scale(1.1); }

    .date-badge {
        position: absolute; top: 15px; left: 15px;
        background: white; color: #333;
        border-radius: 8px; text-align: center;
        padding: 5px 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .date-badge .month { display: block; font-size: 0.8em; text-transform: uppercase; font-weight: bold; color: #dc3545; }
    .date-badge .day { display: block; font-size: 1.5em; font-weight: 900; line-height: 1; }

    .event-details { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
    .event-details h3 { margin: 0 0 10px; color: #003366; font-size: 1.4em; }
    .event-meta { color: #777; font-size: 0.9em; margin-bottom: 15px; display: flex; gap: 15px; }
    .event-meta i { color: #007bff; }
    
    .event-desc { color: #555; line-height: 1.6; flex-grow: 1; margin-bottom: 20px; }
</style>

<div class="events-header">
    <h2>Upcoming Events & Festivals</h2>
    <p>Join the celebration in Manaoag.</p>
</div>

<div class="events-grid">
    <?php if (empty($events)): ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 50px; color: #777;">
            <i class="fa-regular fa-calendar-xmark" style="font-size: 3em; margin-bottom: 15px;"></i>
            <p>No upcoming events scheduled.</p>
        </div>
    <?php else: ?>
        <?php foreach ($events as $event): ?>
            <?php 
                $date = strtotime($event['start_date']);
                $month = date('M', $date);
                $day = date('d', $date);
            ?>
            <div class="event-card">
                <div class="event-img-box">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($event['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                    
                    <div class="date-badge">
                        <span class="month"><?php echo $month; ?></span>
                        <span class="day"><?php echo $day; ?></span>
                    </div>
                </div>
                
                <div class="event-details">
                    <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
                    
                    <div class="event-meta">
                        <span><i class="fa-regular fa-clock"></i> <?php echo date('g:i A', $date); ?></span>
                        <span><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($event['location']); ?></span>
                    </div>
                    
                    <p class="event-desc"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                    
                    <button style="width:100%; padding:10px; background:#f0f2f5; border:none; color:#333; font-weight:bold; border-radius:8px; cursor:pointer; transition:0.2s;" onmouseover="this.style.background='#e4e6eb'" onmouseout="this.style.background='#f0f2f5'">
                        <i class="fa-regular fa-calendar-plus"></i> Add to Calendar
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>