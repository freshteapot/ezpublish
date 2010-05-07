<?php
/**
 * File containing the ezpTopologicalSortTest class
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 * @package tests
 */

class ezpExtensionTest extends ezpTestCase
{
    protected $data = array();

    public function setUp()
    {
        ezpINIHelper::setINISetting( 'site.ini', 'ExtensionSettings', 'ExtensionDirectory', 'tests/tests/kernel/classes/extensions' );
        eZCache::clearByID( 'active_extensions' );
        parent::setUp();
    }

    public function tearDown()
    {
        ezpINIHelper::restoreINISettings();
        eZCache::clearByID( 'active_extensions' );
        parent::tearDown();
    }

    /**
     * @dataProvider providerForGetLoadingOrderTest
     */
    public function testGetLoadingOrder( $extensionName, $expectedResult )
    {
        $extension = ezpExtension::getInstance( $extensionName );
        $loadingOrder = $extension->getLoadingOrder();
        $this->assertSame( $expectedResult, $loadingOrder );
    }

    public static function providerForGetLoadingOrderTest()
    {
        return array(

            // valid extension.xml
            array(
                'ezfind',
                array( 'after' => array( 'ezjscore' ), 'before' => array( 'ezwebin', 'ezflow' ) ),
            ),

            // only 'requires' dependency
            array(
                'ezdeprequires',
                array( 'after' => array( 'ezjscore' ) ),
            ),

            // only 'uses' dependency
            array(
                'ezdepuses',
                array( 'after' => array( 'ezjscore' ) ),
            ),

            // only 'extends' dependency
            array(
                'ezdepextends',
                array( 'before' => array( 'ezwebin', 'ezflow' ) ),
            ),

            // invalid XML
            array(
                'ezdepinvalid',
                null,
            ),
        );
    }

    /**
     * @dataProvider providerForGetInfoTest
     */
    public function testGetInfo( $extensionName, $expectedResult )
    {
        $extension = ezpExtension::getInstance( $extensionName );
        $info = $extension->getInfo();
        $this->assertSame( $expectedResult, $info );
    }

    public static function providerForGetInfoTest()
    {
        $ezfindInfoArray = array(
            'name' => "eZ Find",
            'version' => 'test version',
            'copyright' => "Copyright © 2008-2009 eZ Systems AS.",
            'info_url' => "http://ez.no",
            'license' => "GNU General Public License v2.0",
            'Includes the following third-party software' =>
            array( 'name' => 'Solr',
                   'version' => '1.4-dev-rev 814543',
                   'copyright' => 'The Apache Software Foundation',
                   'license' => 'Apache License, Version 2.0',
                   'info_url' => 'http://lucene.apache.org/solr/' ) );
        $ezfindOldinfoArray = array(
            'Name' => "eZ Find",
            'Version' => 'test version',
            'Copyright' => "Copyright © 2008-2009 eZ Systems AS.",
            'Info_url' => "http://ez.no",
            'License' => "GNU General Public License v2.0",
            '3rdparty_software' =>
            array( 'name' => 'Solr',
                   'Version' => '1.4-dev-rev 814543',
                   'copyright' => 'The Apache Software Foundation.',
                   'license' => 'Apache License, Version 2.0',
                   'info_url' => 'http://lucene.apache.org/solr/' ) );

        return array(
            // valid and complete extension.xml
            array( 'ezfind', $ezfindInfoArray ),

            // invalid extension.xml
            array( 'ezinfoinvalid', null ),

            // extension using ezinfo.php
            array( 'ezinfoold', $ezfindOldinfoArray )
        );
    }

}
?>