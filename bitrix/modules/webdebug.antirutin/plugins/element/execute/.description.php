<p>Это специальный плагин, который подойдет только для специальных целей: например, для разработчиков, или для выполнения произвольных действий, а также при предоставлении кода от разработчиков модуля.</p>
<p>Краткие нюансы работы плагина:</p>
<ul>
	<li>код должен вернуть либо <code><b>true</b></code> (обработка элемента успешно завершена) либо <code><b>false</b></code> (при выполнении произошла ошибка, при этом текст ошибки можно задать через <nobr><code><b>$this->setError('Error text')</b></code></nobr>),</li>
	<li>код выполняется в контексте класса плагина (<code><b>PluginElement</b></code>, наследован от <code><b>Plugin</b></code>), поэтому доступна переменная <code><b>$this</b></code>, являющаяся объектом текущего плагина,</li>
	<li>идентификатор (ID) текущего элемента доступен в переменной <code><b>$intElementId</b></code>,</li>
	<li>идентификатор инфоблока доступен в <nobr><code><b>$this->intIBlockId</b></code></nobr>,</li>
	<li>идентификатор инфоблока торговых предложений можно получить методом <nobr><code><b>$this->getOffersIBlockId()</b></code></nobr>,</li>
	<li>большинство полезных функций, которые может понадобиться при разработке уже разработано, смотрите классы <code><b>Plugin</b></code>, <code><b>PluginElement</b></code>, <code><b>Helper</b></code>, <code><b>IBlock</b></code>, также в качестве примеров можно смотреть код других плагинов.</li>
</ul>
<p><a href="https://www.webdebug.ru/marketplace/webdebug.antirutin/?tab=faq#36292" target="blank">Дополнительная информация</a></p>
<p>Имейте ввиду, что любой прописанный код выполняется на сервере, что <b>небезопасно</b> само по себе. Кроме того, важно понимать что прописанный здесь код может как выполнить полезную работу, так и что-либо сломать.</p>
<p><br/></p>
