<li class="menu-header">Main Menu</li>
<li><a class="nav-link" href="<?=site_url('beranda')?>"><i class="fas fa-fire"></i> <span>Home</span></a></li>
<?php if(isSuperAdmin()) :?>
    <li><a class="nav-link" href="<?=site_url('settings/mainmenu')?>"><i class="fas fa-cogs"></i><span>Main Menu</span></a></li>
<?php endif; ?>
<?php if(isSuperAdmin()) :?>
    <li><a class="nav-link" href="<?=site_url('settings/accessmenu')?>"><i class="fas fa-cogs"></i><span>Setup Access Menu</span></a></li>
<?php endif; ?>
<?php if(isSuperAdmin()) :?>
    <li><a class="nav-link" href="<?=site_url('settings/user_groups')?>"><i class="fas fa-cogs"></i><span>UserGroups</span></a></li>
<?php endif; ?>