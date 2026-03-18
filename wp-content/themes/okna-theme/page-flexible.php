<?php
/**
 * Template Name: Гибкая страница (ACF Blocks)
 * Description: Шаблон с гибкими блоками ACF для тестирования
 */

get_header();
?>

<div class="wrapper main">
    <?php // Подключаем рендер блоков ?>
    <?php include get_template_directory() . '/template-parts/render-flexible-blocks.php'; ?>
    
    <?php // Выводим все блоки из поля "flexible_blocks" ?>
    <?php render_flexible_blocks( 'flexible_blocks' ); ?>
</div>

<?php get_footer(); ?>
