<?php
use yii\helpers\Url;
?>


<!-- stats in tailwind -->

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="md:col-span-1 bg-surface-container-low p-6 rounded-xl flex flex-col justify-between">
            <span class="text-on-surface-variant text-sm font-medium">Active Users</span>
            <div class="mt-4">
                <span class="text-3xl font-black text-on-surface"><?= Yii::$app->dashboard->countActiveUsers() ?></span>
                <!-- <span class="text-green-600 text-xs font-bold ml-2">↑ 12%</span> -->
            </div>
        </div>
        <div class="md:col-span-1 bg-surface-container-low p-6 rounded-xl flex flex-col justify-between">
            <span class="text-on-surface-variant text-sm font-medium">Inactive Users</span>
            <div class="mt-4">
                <span class="text-3xl font-black text-on-surface"><?= Yii::$app->dashboard->countInactiveUsers() ?></span>
            </div>
        </div>
       
    </div>