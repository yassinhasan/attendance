

    
    <?php 
       $type = null;
        foreach ($js as $key) {?>

    <script src="<?= assets("$key")?>" > </script>
    <?php  }
    ?>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>