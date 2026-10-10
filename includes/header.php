<?php
// ============================================================
// Techno Coderz — Header Include
// Usage: set $pageTitle and $pageMeta before including
// ============================================================
if (!isset($pageTitle))       $pageTitle       = 'Techno Coderz – IT Training & Software Development';
if (!isset($pageDescription)) $pageDescription = 'Techno Coderz is a premier IT training and software development company offering industry-focused courses in PHP, Java, Full Stack, and more.';
if (!isset($currentPage))     $currentPage     = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <meta name="keywords" content="IT training, software development, PHP course, Java course, web development, Techno Coderz">
  <meta name="author" content="Techno Coderz">
  <!-- Open Graph -->
  <meta property="og:title" content="<?= e($pageTitle) ?>">
  <meta property="og:description" content="<?= e($pageDescription) ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= SITE_URL ?>">
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= SITE_URL ?>/assets/images/favicon.svg">
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Techno Coderz Custom CSS -->
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/technocoderz.css?v=<?= filemtime(__DIR__ . '/../assets/css/technocoderz.css') ?>">
</head>
<body>
