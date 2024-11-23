<div class="notifications">
    <h5>Notifikasi</h5>
    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $notification): ?>
            <div class="alert alert-info">
                <strong><?= esc($notification['comment_user']) ?></strong> mengomentari postingan Anda.
                <small><?= $notification['created_at'] ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada notifikasi baru.</p>
    <?php endif; ?>
</div>
