<section id="contact" class="mb-3 p-4">
    <div class="pattern-overlay stripe-pattern pattern-opacity-quarter"></div>
    
    <h3 class="h5 text-primary mb-3">How may I help you?</h3>
    
    <?php
    if($pagename !== "contact") { ?>
        <a href="<?php echo site_url(); ?>/contact" class="btn btn-primary d-block d-sm-inline-block mb-2">Contact Me</a>
    <?php
    }
    ?>
    
    <a href="<?php echo site_url(); ?>/resume.pdf" target="_blank" class="btn btn-primary d-block d-sm-inline-block mb-2">View My Resume</a>
    
</section>