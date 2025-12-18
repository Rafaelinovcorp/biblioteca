<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f3f4f6; padding:20px; }
        .card { background:#ffffff; padding:20px; border-radius:8px; max-width:600px; margin:auto; }
        .header { font-size:20px; font-weight:bold; margin-bottom:10px; }
        .btn {
            display:inline-block;
            background:#2563eb;
            color:#ffffff;
            padding:10px 16px;
            border-radius:6px;
            text-decoration:none;
            margin-top:15px;
        }
        img { max-width:120px; margin-bottom:10px; }
        .footer { margin-top:20px; font-size:12px; color:#6b7280; }
    </style>
</head>
<body>
    <div class="card">
        <?php echo $__env->yieldContent('content'); ?>
        <div class="footer">
            Biblioteca Digital • <?php echo e(date('Y')); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Rafael\Herd\biblioteca\resources\views/emails/layout.blade.php ENDPATH**/ ?>