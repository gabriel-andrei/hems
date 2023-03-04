<?php 
    require_once('../config.php');
    $sql = "SELECT l.* , p.price as 'old_price', p.base_price as 'old_base_price', p.percentage as 'old_percentage'
        FROM product_price_notifs l LEFT JOIN product_list p ON p.id=l.product_id
        WHERE is_hidden=0 order by product_id, date_effect";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        extract($row);
        var_dump($from_price);
    }
?>

<script>
    $(function() {
        Command: toastr["success"]("Price changed from 123 to 12312 as of today.", "Product Name")

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>