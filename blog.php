<?php
// =============================================
// BLOG DETAIL PAGE
// =============================================
require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$post = $slug ? getBlogPost($slug) : null;

if (!$post) {
    header('Location: /#blog');
    exit;
}

trackVisitor('/blog/' . $slug);
$settings = getAllSettings();
include __DIR__ . '/partials/header.php';
?>

<main style="padding-top: 100px; min-height: 80vh;">
    <div class="section">
        <div class="section-inner" style="max-width: 800px;">
            <article>
                <div style="margin-bottom: 2rem;">
                    <span class="blog-card-category"><?php echo htmlspecialchars($post['category'] ?? 'General'); ?></span>
                    <h1 style="font-family: var(--font-display); font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 700; margin: 1rem 0;"><?php echo htmlspecialchars($post['title']); ?></h1>
                    <div style="color: var(--text-tertiary); display: flex; gap: 1.5rem; flex-wrap: wrap;">
                        <span>By <?php echo htmlspecialchars($post['author'] ?? 'Alenmodwebhub'); ?></span>
                        <span><?php echo formatDate($post['created_at']); ?></span>
                        <span><?php echo (int)$post['reading_time']; ?> min read</span>
                    </div>
                </div>

                <?php if ($post['cover_image']): ?>
                <div style="border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 2rem;">
                    <img src="<?php echo htmlspecialchars($post['cover_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" style="width: 100%;">
                </div>
                <?php endif; ?>

                <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text-secondary);">
                    <?php echo $post['content']; ?>
                </div>

                <?php
                $tags = json_decode($post['tags'], true) ?? [];
                if (count($tags) > 0):
                ?>
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border-glass);">
                    <strong style="color: var(--text-primary);">Tags:</strong>
                    <div class="project-card-tags" style="margin-top: 0.5rem;">
                        <?php foreach ($tags as $tag): ?>
                        <span class="project-tag"><?php echo htmlspecialchars($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </article>
        </div>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
