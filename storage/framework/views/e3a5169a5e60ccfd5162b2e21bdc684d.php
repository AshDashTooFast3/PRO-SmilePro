<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            <?php echo e($title); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-white dark:text-gray-100 text-lg font-medium">Overzicht van medewerkers</span>
                </div>

                <div class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="container">
                        <h1 class="mb-6 text-center text-3xl font-bold text-white dark:text-gray-100">Medewerker
                            Overzicht</h1>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700 text-white">
                                <thead class="bg-gray-900">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                            Medewerkernummer</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                            Naam</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                            Type</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                            Specialisatie</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                            Beschikbaarheid</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                            Actief</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                            Opmerking</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                    <?php $__empty_1 = true; $__currentLoopData = $medewerkers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="hover:bg-gray-700">
                                            <td class="px-4 py-3"><?php echo e($m->Nummer); ?></td>
                                            <td class="px-4 py-3">
                                                <?php if($m->persoon): ?>
                                                    <?php echo e($m->persoon->Voornaam); ?>

                                                    <?php if($m->persoon->Tussenvoegsel): ?>
                                                        <?php echo e($m->persoon->Tussenvoegsel); ?>

                                                    <?php endif; ?>
                                                    <?php echo e($m->persoon->Achternaam); ?>

                                                <?php else: ?>
                                                    <em>Onbekend</em>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4 py-3"><?php echo e($m->Medewerkertype); ?></td>
                                            <td class="px-4 py-3"><?php echo e($m->Specialisatie ?? '-'); ?></td>
                                            <td class="px-4 py-3"><?php echo e($m->Beschikbaarheid ?? '-'); ?></td>
                                            <td class="px-4 py-3"><?php echo e($m->Isactief ? 'Ja' : 'Nee'); ?></td>
                                            <td class="px-4 py-3"><?php echo e($m->Opmerking ?? '-'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">Geen medewerkers gevonden.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /home/hamid/phpprojecten/SmilePro/resources/views/Medewerker/MedewerkerOverzicht.blade.php ENDPATH**/ ?>