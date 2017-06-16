<form method="<?php echo $config["options"]["method"];?>"
    id="<?php echo (isset($config["options"]["id"])) ? $config["options"]["id"] : "" ;?>"
    class="<?php echo $config["options"]["class"];?>"
    action="<?php echo $config["options"]["action"];?>"
    enctype="<?php
    if (isset($config["options"]["enctype"]))
        echo $config["options"]["enctype"];
    else
        echo "application/x-www-form-urlencoded";
        ?>"
>


    <?php foreach ($config["struc"] as $name => $attribute):?>
        <?php if ($attribute['type'] == "label"): ?>
            <label for="<?php echo $attribute['for']; ?>"><?php echo $attribute['text']; ?></label>
        <?php elseif(
            $attribute['type'] == "email" ||
            $attribute['type'] == "password" ||
            $attribute['type'] == "text" ||
            $attribute['type'] == "file"
        ):?>
            <input type="<?php echo $attribute["type"];?>"
                   name="<?php echo $name?>"
                   placeholder="<?php echo $attribute["placeholder"];?>"
                   value="<?php echo $attribute["value"];?>"
                   id="<?php echo (isset($attribute ["id"])) ? $attribute ["id"] : ""; ?>"
                   <?php echo (isset($attribute["required"]) && $attribute["required"]) ? "required='required'" : ""?>>
        <?php
        endif;
    endforeach;

    if (isset($config["options"]["captcha"]) && $config["options"]["captcha"]): ?>
    <div class="g-recaptcha" data-sitekey="6LeftiQUAAAAAJO-QKv1u7redcYNbwLRgszt0IBR"></div>
    <?php endif; ?>

    <input type="submit" value="<?php echo $config["options"]["submit"]; ?>" name="<?php echo $config["options"]["submitName"] ?>">
</form>
