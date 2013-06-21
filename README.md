select-checkbox-combo
=====================

A custom clipper/modx TV to generate a select/checkbox combo from resources


Install:
- Copy files to assets/tvs/select-checkbox-combo
- Edit the config.inc.php to setup the start id for generating the combo
- Create a new TV and name it accordigly
- Select Custom Input in Input Type
- Enter '@INCLUDE/assets/tvs/select-checkbox-combo/select-checkbox-combo.php' for Input Option Values
- Assign the template, save and use

Sample:

![See example](https://raw.github.com/Cipa/select-checkbox-combo/master/assets/tvs/select-checkbox-combo/sample.png)


Next:
- array config instead of resource parent
- config option to use a select instead of checkboxes
- better language support
- recursive
- ajax query for the children(not sure if needed unless a recursive solution is implemented)
