<?php

/**
 * This file is part of the propel-enable-behavior package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Altern\Propel\Behavior\EnableDisable;

use Propel\Generator\Model\Behavior;

/**
 * Description of OnoffableBehavior
 *
 * @author berduj
 */
class EnableDisableBehavior extends Behavior {

    protected $parameters = array(
            //'name' => 'enable',
    );

    public function modifyTable() {
        $table = $this->getTable();
        $columnName = "enabled";

        if (!$table->hasColumn($columnName)) {
            $table->addColumn(array(
                'name' => $columnName,
                'type' => 'boolean',
                'default' => true
            ));
        }
    }

    public function objectMethods() {
        $script = "      
 /**
 * Toggle Enabled/Disabled
 *
 * @return \$this The current object (for fluent API support)
 */
public function toggleEnabled()
{
     \$this->setEnabled(!\$this->getEnabled());
     return \$this;
}

 /**
 * Force Enabled
 *
 * @return \$this The current object (for fluent API support)
 */
public function enable()
{
     \$this->setEnabled(true);
     return \$this;
}

 /**
 * Force Disabled
 *
 * @return \$this The current object (for fluent API support)
 */
public function disable()
{
     \$this->setEnabled(false);
     return \$this;
}


";
        return $script;
    }

    public function queryMethods($builder) {
        $queryClassName = $builder->getQueryClassName();

        $script = "
/**
 * Find enabled only
 *
 * @return ObjectCollection|ActiveRecordInterface[]|array|mixed the list of results, formatted by the current formatter
 */
public function FindEnabled()
{
    return \$this->filterByEnabled(true)->find();
}

/**
 * Find disabled only
 *
 * @return ObjectCollection|ActiveRecordInterface[]|array|mixed the list of results, formatted by the current formatter
 */
public function FindDisabled()
{
    return \$this->filterByEnabled(false)->find();
}

";
        return $script;
    }

}
