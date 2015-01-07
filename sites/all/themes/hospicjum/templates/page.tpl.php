<?php print render($page['admin-tools']); ?>
<div class="container header-container">
	<div id="header-wrapper">
		<header>
                        <?php print render($page['header-green-bar']); ?>
			<a href="<?php print $base_path;?>" id="logo"></a>
                        <nav id="top-menu">
                            <?php print render($page['header-menu']); ?>
                            <?php 
                                /*$menu = menu_tree('menu-top-menu');
                                $menuhtml = drupal_render($menu);
                                print $menuhtml;*/
                            ?>
                        </nav>
                        <section id="intro-text">
                            <?php print render($page['header-description']); ?>
                        </section>
		</header>
	</div>
</div>

<div class="container">
	<div class="row bordered">		
		<div class="span2">
			<nav id="main-menu">
				<?php print render($page['menu']); ?>
			</nav>
            <?php if($page['sidebarLeft']): ?>
                <?php print render($page['sidebarLeft']); ?>
            <?php endif; ?>
		</div>
		
		<div class="span12">
		<?php if($page['submenu']): ?>
			<div id="submenu"><?php //print render($page['submenu']); ?></div>
		<?php endif; ?>	
		
		<?php if ($messages): ?>
		<div id="messages">
			<?php print $messages; ?>
		</div>
		<?php endif; ?>


        <?php if ($page['sidebarRight']): ?>
            <div id="sidebarRight" class="span5">
                <?php print render($page['sidebarRight']); ?>
            </div>
        <?php endif; ?>
            
		<?php if($page['sidebar']): ?>
			<div class="span7">
				<section><?php print render($page['content']); ?></section>
			</div>
			<div class="span5">
				<aside><?php print render($page['sidebar']); ?></aside>
			</div>
		<?php else: ?>
			<section>
			<?php print render($page['content']); ?>
			</section>
		<?php endif; ?>
		</div>
	</div>
</div>

<footer class="container">
    <section>
        <?php print render($page['footer']); ?>
    </section>
</footer>

<script>
jQuery(document).ready(function($){
	$('html').removeClass('no-js');
});
</script>