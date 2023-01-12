<?php $this->load->view('partial/header'); ?>

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
      </ul>
      <h1><?php echo $html_title;?></h1>      
      <div class="row">
        <div class="span12 columns">
          <div class="well">
            <?php echo $output; ?>
      	</div>
        <? if (isset($footer)):?>
        <div>
             <?php echo $footer; ?>
        </div>
        <? endif; ?>
    </div>
    </div>
<?php //echo $output; ?>


<?php $this->load->view('partial/footer'); ?>