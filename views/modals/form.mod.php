<form method="<?php echo $config["options"]["method"];?>"
    id="<?php echo $config["options"]["id"];?>"
    class="<?php echo $config["options"]["class"];?>"
    action="<?php echo $config["options"]["action"];?>">


    <?php foreach ($config["struc"] as $name => $attribute):?>
        <?php if(
            $attribute['type'] == "email" ||
            $attribute['type'] == "password" ||
            $attribute['type'] == "text" ||
            $attribute['type'] == "file"
        ):?>
            <input type="<?php echo $attribute["type"];?>"
                   name="<?php echo $name?>"
                   placeholder="<?php echo $attribute["placeholder"];?>"
                   value="<?php echo $attribute["value"];?>"
                   <?php echo (isset($attribute["required"]) && $attribute["required"]) ? "required='required'" : ""?>>
        <?php endif;?>
    <?php endforeach;?>

    <input type="submit" value="<?php echo $config["options"]["submit"]; ?>" name="<?php echo $config["options"]["submitName"] ?>">
</form>
