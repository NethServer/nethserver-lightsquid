<?php

echo $view->header()->setAttribute('template', $T('Settings_title'));

echo $view->panel()
    ->insert($view->selector('Lang', $view::SELECTOR_DROPDOWN))
    ->insert($view->textInput('BigFileLimit'))
    ->insert($view->textInput('PerUserTrafficLimit'));;

echo $view->buttonList($view::BUTTON_SUBMIT | $view::BUTTON_CANCEL | $view::BUTTON_HELP);

