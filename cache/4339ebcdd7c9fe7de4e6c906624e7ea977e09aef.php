

<?php $__env->startSection('title','Create Employee'); ?>

<?php $__env->startSection('content'); ?>
<form method="post" action="index.php?action=store">
    <input name="name" placeholder="Name" required><br><br>
    <input name="title" placeholder="Job Title" required><br><br>
    <input name="skills" placeholder="Skills (comma separated)" required><br><br>
    <button>Save</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FullStack\Workshop_8\app\views/employee/create.blade.php ENDPATH**/ ?>