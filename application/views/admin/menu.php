<div style="background:url(data/images/admin.jpg) no-repeat;background-position: center center;width:251px;height:243px;"></div>

<? foreach ($menu as $category => $item): ?>
    <div class="category"><?= $category ?></div>
    <div class="block">
    <? foreach ($item as $key => $module): ?>
	   <a href="admin/<?= $module ?>" style="padding:0 0 2px 3px;"><?= $key ?></a><br/>
    <? endforeach; ?>
    </div>
<? endforeach; ?>