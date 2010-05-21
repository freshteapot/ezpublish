<?php
/**
 * File containing the ezpContentLocationCriteria class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package API
 */

/**
 * This class allows for configuration of a location based criteria
 * @package API
 */
class ezpContentLocationCriteria
{
    /**
     * Sets a subtree criteria.
     * Content will only be accepted if it is part of the given subtree
     *
     * @param ezpLocation $subtree
     * @return ezpContentLocationCriteria
     */
    public function subtree( ezpLocation $subtree )
    {
        $this->subtree = $subtree;
        return $this;
    }

    private $subtree;
}
?>