<a href="#masonryBox" class="filterClick">All</a>
<a href="#tagText" class="filterClick">Text</a>
<a href="#tagImages" class="filterClick">Images</a>
<a href="#tagFiles" class="filterClick">Files</a>


<div class="masonry">
    <div class="masonryBox tagText">
		<h3><i class="icon-th-large"></i> <?php echo $this->Html->link('Webpages', array('plugin' => 'webpages', 'controller' => 'webpages', 'action' => 'index', 'type' => 'page_content')); ?></h3>
        <p>Manage static content pages.</p>
    </div>
    
    <div class="masonryBox tagImages">
		<h3><i class="icon-picture"></i> <?php echo $this->Html->link('Image Manager', array('plugin' => 'media', 'controller' => 'media', 'action' => 'images')); ?></h3>
        <p>Just like your desktop, manage server images.</p>
    </div>
    
    <div class="masonryBox tagFiles">
    	<h3><i class="icon-folder-close"></i> <?php echo $this->Html->link('File Manager', array('plugin' => 'media', 'controller' => 'media', 'action' => 'files')); ?></h3>
        <p>Just like your desktop, manage server files (pdfs, docs, xls, etc).</p>
    </div>
    
    <div class="masonryBox tagText">
		<h3><i class="icon-file"></i> <?php echo $this->Html->link('Blogs', array('plugin' => 'blogs', 'controller' => 'blogs', 'action' => 'index')); ?></h3>
        <p>Create multiple blogs, and post new content.</p>
    </div>
    
    <div class="masonryBox tagText">
		<h3><i class="icon-comment"></i> <?php echo $this->Html->link('Comments', array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'index')); ?></h3>
        <p>See and the discussions going on.</p>
    </div>
    
    <div class="masonryBox tagImages">
		<h3><i class="icon-picture"></i> <?php echo $this->Html->link('Galleries', array('plugin' => 'galleries', 'controller' => 'galleries', 'action' => 'index')); ?></h3>
        <p>Add and edit image and video galleries</p>
    </div>
    
    <div class="masonryBox tagText">
		<h3><i class="icon-tasks"></i> <?php echo $this->Html->link('Categories', array('plugin' => 'categories', 'controller' => 'categories', 'action' => 'index')); ?></h3>
        <p>Categorize anything.  Move, reorder, add, edit categories.</p>
    </div>
    
    <div class="masonryBox tagText">
		<h3><i class="icon-tags"></i> <?php echo $this->Html->link('Tags', array('plugin' => 'tags', 'controller' => 'tags', 'action' => 'index')); ?></h3>
        <p>Tag anything.  Move, reorder, add, edit tags.</p>
    </div>
    
    <div class="masonryBox tagText">
		<h3><i class="icon-globe"></i> <?php echo $this->Html->link('Enumerations', array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index')); ?></h3>
        <p>Manage your own system lists</p>
    </div>
    
</div>

<script type="text/javascript">
$(function () { 
		
});
</script>