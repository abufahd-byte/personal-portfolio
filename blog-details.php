<?php
require_once 'config/config.php';

if (!isset($_GET['slug']) || empty($_GET['slug'])) { header("Location: blog.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = :slug AND status = 'Published'");
$stmt->execute([':slug' => $_GET['slug']]);
$post = $stmt->fetch();

if (!$post) { header("Location: blog.php"); exit; }

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<div class="page-header">
  <div class="container">
    <div style="display:flex; justify-content:center; gap:1.5rem; font-size:0.85rem; color:var(--text-muted); margin-bottom:0.8rem;">
      <span><i class="fa-solid fa-calendar-days"></i> <?= date('d M Y', strtotime($post->created_at)) ?></span>
      <span><i class="fa-solid fa-user"></i> <?= e($post->author) ?></span>
    </div>
    <h1 style="font-size:clamp(1.5rem,3vw,2.2rem); max-width:700px; margin:0 auto; line-height:1.4;">
      <?= e($post->{'title_'.$lang}) ?>
    </h1>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width:850px;">

    <div style="margin-bottom:1.5rem;">
      <a href="blog.php" class="btn btn-outline btn-sm">
        <i class="fa-solid fa-arrow-<?= $lang == 'ar' ? 'right' : 'left' ?>"></i> <?= __('back_to_blog') ?>
      </a>
    </div>

    <?php if ($post->image && file_exists(ROOT_PATH . 'uploads/blog/' . $post->image)): ?>
    <div class="reveal" style="border-radius:var(--radius-xl); overflow:hidden; margin-bottom:2rem;">
      <img src="<?= BASE_URL ?>uploads/blog/<?= $post->image ?>" alt="<?= e($post->{'title_'.$lang}) ?>" style="width:100%; max-height:450px; object-fit:cover; display:block;">
    </div>
    <?php endif; ?>

    <div class="reveal delay-1" style="background:var(--bg-card); padding:clamp(1.5rem,4vw,3rem); border-radius:var(--radius-xl); border:1px solid var(--border);">
      <p style="font-size:1.15rem; font-weight:600; color:var(--text-secondary); margin-bottom:2rem; padding-bottom:2rem; border-bottom:1px solid var(--border); line-height:1.9;">
        <?= e($post->{'short_description_'.$lang}) ?>
      </p>

      <div class="blog-body" style="font-size:1.05rem; line-height:2; color:var(--text-primary);">
        <?= $post->{'content_'.$lang} ?>
      </div>
    </div>

    <!-- Share -->
    <div class="text-center reveal" style="padding:2rem 0;">
      <p style="color:var(--text-muted); font-weight:600; margin-bottom:1rem;"><?= __('blog_share') ?></p>
      <div style="display:flex; justify-content:center; gap:0.7rem;">
        <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post->{'title_'.$lang}) ?>&url=<?= urlencode(BASE_URL.'blog-details.php?slug='.$post->slug) ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-twitter"></i></a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASE_URL.'blog-details.php?slug='.$post->slug) ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(BASE_URL.'blog-details.php?slug='.$post->slug) ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-linkedin-in"></i></a>
      </div>
    </div>

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
