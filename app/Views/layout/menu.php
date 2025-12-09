<li class="menu-header">Main Menu</li>
 <?php $menus = live_user_menu();?>
<?php if($menus!=null):?>
   <?php foreach ($menus as $key => $value):?>
 <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="<?= $value['icon_image'] ?>"></i><span><?= $value['name']?></span></a>
        <ul class="dropdown-menu">
        <?php foreach ($value['module'] as $subkey => $subvalue):?>
            <li><a class="nav-link" href="<?=site_url($subvalue['url'])?>"><i class="<?= $subvalue['icon_image'] ?>"></i><?= $subvalue['name'] ?></a></li>
        <?php endforeach?> 
        </ul>
        </li>
    <?php endforeach?>
<?php endif?>