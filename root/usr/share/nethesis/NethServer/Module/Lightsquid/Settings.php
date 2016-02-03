<?php

namespace NethServer\Module\Lightsquid;

/*
 * Copyright (C) 2011 Nethesis S.r.l.
 * 
 * This script is part of NethServer.
 * 
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

use Nethgui\System\PlatformInterface as Validate;

/**
 * Change lightsquid settings
 *
 * @author Giacomo Sanchietti<giacomo.sanchietti@nethesis.it>
 */
class Settings extends \Nethgui\Controller\AbstractController
{

    private $langs = array();

    private function getLanguages()
    {
        $langs = array();
        foreach(glob("/usr/share/lightsquid/lang/*.lng") as $f) {
            $tmp = explode('.', basename($f));
            $langs[] = $tmp[0];
        }
        return $langs;
    }

    public function initialize()
    {
        parent::initialize();
        if (!$this->langs) {
            $this->langs = $this->getLanguages();
        }
        $this->declareParameter('Lang', $this->createValidator()->memberOf($this->langs), array('configuration', 'lightsquid', 'Lang'));
        $this->declareParameter('BigFileLimit', Validate::POSITIVE_INTEGER, array('configuration', 'lightsquid', 'BigFileLimit'));
        $this->declareParameter('PerUserTrafficLimit', Validate::POSITIVE_INTEGER, array('configuration', 'lightsquid', 'PerUserTrafficLimit'));
    }

    protected function onParametersSaved($changes)
    {
        $this->getPlatform()->signalEvent('nethserver-ligthsquid-save');
    }


    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        parent::prepareView($view);

        if (!$this->langs) {
            $this->langs = $this->getLanguages();
        }

        $view['LangDatasource'] = array_map(function($fmt) use ($view) {
                return array($fmt, $view->translate($fmt));
            }, $this->langs);
        if ($this->getRequest()->isValidated()) {
            $view->getCommandList()->show();
        }
    }

}
