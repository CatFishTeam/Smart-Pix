<form method="<?php echo $config["options"]["method"];?>"
    id="<?php echo $config["options"]["id"];?>"
    class="<?php echo $config["options"]["class"];?>"
    action="<?php echo $config["options"]["action"];?>">


    <?php foreach ($config["struc"] as $name => $attributs):?>
        <?php if($attributs["type"]=="email"):?>
            <input type="<?php echo $attributs["type"];?>"
                   name="<?php echo $name?>"
                   placeholder="<?php echo $attributs["placeholder"];?>"
                   <?php echo (isset($attributs["required"])) ? "required='required'" : ""?>
        <?php endif;?>
    <?php endforeach;?>

    <button type="submit"><?php echo $config["options"]["submit"]; ?></button>
</form>
