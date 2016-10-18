<h2><?php echo $title; ?></h2>

<?php foreach ($cards as $card): ?>

        <h3><?php echo $card['title']; ?></h3>
        <div class="main">
                <?php echo $card['description']; ?>
        </div>
        <p><a href="<?php echo site_url('photos/'.$card['card_id']); ?>">View Card</a></p>

<?php endforeach; ?>