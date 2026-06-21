<?php
require_once __DIR__ . '/includes/functions.php';
$settings = getAllSettings();
include __DIR__ . '/partials/header.php';
?>
<main>
    <section class="section" style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;">
        <div class="section-inner">
            <div style="font-size:8rem;font-weight:900;background:linear-gradient(135deg,var(--primary),var(--secondary));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;">500</div>
            <h1 class="section-title" style="margin-top:1rem;">Server Error</h1>
            <p style="color:var(--text-secondary);max-width:500px;margin:1rem auto 2rem;">Something went wrong on our end. Please try again later.</p>
            <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary btn-lg">Back to Home</a>
        </div>
    </section>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
