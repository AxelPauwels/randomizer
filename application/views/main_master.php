<!--      ██████╗ ███████╗██╗   ██╗███████╗██╗      ██████╗ ██████╗ ██████╗ ███████╗██████╗     ██████╗ ██╗   ██╗               -->
<!--      ██╔══██╗██╔════╝██║   ██║██╔════╝██║     ██╔═══██╗██╔══██╗██╔══██╗██╔════╝██╔══██╗    ██╔══██╗╚██╗ ██╔╝               -->
<!--      ██║  ██║█████╗  ██║   ██║█████╗  ██║     ██║   ██║██████╔╝██████╔╝█████╗  ██║  ██║    ██████╔╝ ╚████╔╝                -->
<!--      ██║  ██║██╔══╝  ╚██╗ ██╔╝██╔══╝  ██║     ██║   ██║██╔═══╝ ██╔═══╝ ██╔══╝  ██║  ██║    ██╔══██╗  ╚██╔╝                 -->
<!--      ██████╔╝███████╗ ╚████╔╝ ███████╗███████╗╚██████╔╝██║     ██║     ███████╗██████╔╝    ██████╔╝   ██║                  -->
<!--      ╚═════╝ ╚══════╝  ╚═══╝  ╚══════╝╚══════╝ ╚═════╝ ╚═╝     ╚═╝     ╚══════╝╚═════╝     ╚═════╝    ╚═╝                  -->


<!--                 █████╗ ██╗  ██╗███████╗██╗         ██████╗  █████╗ ██╗   ██╗██╗    ██╗███████╗██╗     ███████╗             -->
<!--      ▄ ██╗▄    ██╔══██╗╚██╗██╔╝██╔════╝██║         ██╔══██╗██╔══██╗██║   ██║██║    ██║██╔════╝██║     ██╔════╝    ▄ ██╗▄   -->
<!--       ████╗    ███████║ ╚███╔╝ █████╗  ██║         ██████╔╝███████║██║   ██║██║ █╗ ██║█████╗  ██║     ███████╗     ████╗   -->
<!--      ▀╚██╔▀    ██╔══██║ ██╔██╗ ██╔══╝  ██║         ██╔═══╝ ██╔══██║██║   ██║██║███╗██║██╔══╝  ██║     ╚════██║    ▀╚██╔▀   -->
<!--        ╚═╝     ██║  ██║██╔╝ ██╗███████╗███████╗    ██║     ██║  ██║╚██████╔╝╚███╔███╔╝███████╗███████╗███████║      ╚═╝    -->
<!--                ╚═╝  ╚═╝╚═╝  ╚═╝╚══════╝╚══════╝    ╚═╝     ╚═╝  ╚═╝ ╚═════╝  ╚══╝╚══╝ ╚══════╝╚══════╝╚══════╝             -->

<!doctype html>
<html lang="en">
<head>
    <?php header('Access-Control-Allow-Origin: *'); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Axel Pauwels">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/icon.ico">

    <title>Randomizer</title>

    <!--CSS (custom css as last)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <?php echo stylesheet("bootstrap.css"); ?>
    <?php echo stylesheet("custom.css"); ?>
</head>

<body>

<div class="nav d-flex flex-row justify-content-between">
	<div class="nav__item text-left p-2">
		<a href="<?php echo site_url('/game/verify') ?>"><i class="fas fa-2x fa-home"></i></a>
	</div>
	<div class="nav__item text-right p-2">
		<a href="<?php echo site_url('/game/giftLists') ?>"><i class="fas fa-2x fa-gift"></i></a>
	</div>
</div>

<?php echo $myContent; ?>
</body>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php //echo javascript("jquery-3.3.1.min.js"); ?>
<script src="<?php echo base_url("node_modules/jquery/dist/jquery.min.js"); ?>"></script>
<?php echo javascript("bootstrap.min.js"); ?>

<!--JS Custom-->
<script type="text/javascript">
    var site_url = '<?php echo site_url(); ?>';
    var base_url = '<?php echo base_url(); ?>';
</script>
<?php echo javascript("game.js"); ?>
</html>
