<?php
require_once 'config/config.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$posts = $pdo->query("SELECT * FROM blog_posts WHERE status = 'Published' ORDER BY created_at DESC")->fetchAll();
?>

<div class="page-header">
  <div class="container">
    <span class="section-badge"><i class="fa-solid fa-pen-nib"></i> <?= __('section_blog_subtitle') ?></span>
    <h1 class="section-title"><?= __('section_blog_title') ?></h1>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="blog-grid">
      <?php if (empty($posts)): ?>
        <div style="grid-column:1/-1; text-align:center; padding:3rem; color:var(--text-muted);">
          <i class="fa-solid fa-folder-open" style="font-size:3rem; opacity:0.3; margin-bottom:1rem; display:block;"></i>
          <p><?= __('no_articles') ?></p>
        </div>
      <?php endif; ?>

      <?php $d = 0; foreach ($posts as $post): ?>
      <div class="blog-card reveal delay-<?= $d % 3 ?>">
        <div class="blog-img">
          <?php if ($post->image && file_exists(ROOT_PATH . 'uploads/blog/' . $post->image)): ?>
            <img src="<?= BASE_URL ?>uploads/blog/<?= $post->image ?>" alt="<?= e($post->{'title_'.$lang}) ?>" loading="lazy" decoding="async">
          <?php else: ?>
            <div class="project-placeholder"><i class="fa-solid fa-newspaper"></i></div>
          <?php endif; ?>
        </div>
        <div class="blog-content">
          <div class="blog-meta">
            <span><i class="fa-solid fa-calendar-days"></i> <?= date('d M Y', strtotime($post->created_at)) ?></span>
            <span><i class="fa-solid fa-user"></i> <?= e($post->author) ?></span>
          </div>
          <h3 class="blog-title"><?= e($post->{'title_'.$lang}) ?></h3>
          <p class="blog-excerpt"><?= e(mb_substr($post->{'short_description_'.$lang}, 0, 100)) ?>...</p>
          <a href="blog-details.php?slug=<?= $post->slug ?>" class="blog-link">
            <?= __('read_more') ?> <i class="fa-solid fa-arrow-<?= $lang == 'ar' ? 'left' : 'right' ?>"></i>
          </a>
        </div>
      </div>
      <?php $d++; endforeach; ?>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
