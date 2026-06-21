<?php
// =============================================
// PROJECT DETAIL PAGE
// =============================================
require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$project = $slug ? getProject($slug) : null;

if (!$project) {
    header('Location: /#projects');
    exit;
}

trackVisitor('/project/' . $slug);
$settings = getAllSettings();
$techs = json_decode($project['technologies'], true) ?? [];
include __DIR__ . '/partials/header.php';
?>

<main style="padding-top: 100px; min-height: 80vh;">
    <div class="section">
        <div class="section-inner" style="max-width: 800px;">
            <article>
                <div style="margin-bottom: 2rem;">
                    <span class="blog-card-category"><?php echo htmlspecialchars($project['category'] ?? 'Web Application'); ?></span>
                    <h1 style="font-family: var(--font-display); font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 700; margin: 1rem 0;"><?php echo htmlspecialchars($project['title']); ?></h1>
                </div>

                <?php if ($project['image']): ?>
                <div style="border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 2rem;">
                    <img src="<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" style="width: 100%;">
                </div>
                <?php endif; ?>

                <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text-secondary);">
                    <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                    <?php if ($project['content']): ?>
                    <div style="margin-top: 1.5rem;"><?php echo $project['content']; ?></div>
                    <?php endif; ?>
                </div>

                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 2rem;">
                    <?php if ($project['live_url']): ?>
                    <a href="<?php echo htmlspecialchars($project['live_url']); ?>" class="btn btn-primary" target="_blank" rel="noopener">Live Preview</a>
                    <?php endif; ?>
                    <?php if ($project['github_url']): ?>
                    <a href="<?php echo htmlspecialchars($project['github_url']); ?>" class="btn btn-secondary" target="_blank" rel="noopener">View on GitHub</a>
                    <?php endif; ?>
                </div>

                <?php if (count($techs) > 0): ?>
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border-glass);">
                    <strong style="color: var(--text-primary);">Technologies Used:</strong>
                    <div class="project-card-tags" style="margin-top: 0.5rem;">
                        <?php foreach ($techs as $tech): ?>
                        <span class="project-tag"><?php echo htmlspecialchars($tech); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($project['problem_solved']): ?>
                <div style="margin-top: 2rem; padding: 1.5rem; background: var(--bg-glass); border: 1px solid var(--border-glass); border-radius: var(--radius-md);">
                    <strong style="color: var(--text-primary);">Problem Solved:</strong>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;"><?php echo nl2br(htmlspecialchars($project['problem_solved'])); ?></p>
                </div>
                <?php endif; ?>

                <?php if ($project['results']): ?>
                <div style="margin-top: 1rem; padding: 1.5rem; background: var(--bg-glass); border: 1px solid var(--border-glass); border-radius: var(--radius-md);">
                    <strong style="color: var(--success);">Results Achieved:</strong>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;"><?php echo nl2br(htmlspecialchars($project['results'])); ?></p>
                </div>
                <?php endif; ?>
            </article>
        </div>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
