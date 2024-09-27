<?php
%A%
		echo 'Noncached content

';
		if (Nette\Bridges\CacheLatte\CacheMacro::createCache($this->global->cacheStorage, '%[\w]+%', $this->global->cacheStack, [$id, 'tags' => 'mytag'])) /* line %d% */ try {
			echo '
<h1>';
			echo LR\Filters::escapeHtmlText(($this->filters->upper)($title)) /* line %d% */;
			echo '</h1>

';
			$this->createTemplate('include.cache.latte', ['localvar' => 11] + $this->params, 'include')->renderToContentType('html') /* line %d% */;
			echo "\n";
			Nette\Bridges\CacheLatte\CacheMacro::endCache($this->global->cacheStack, [$id, 'tags' => 'mytag']) /* line %d% */;
		} catch (\Throwable $ʟ_e) {
			Nette\Bridges\CacheLatte\CacheMacro::rollback($this->global->cacheStack);
			throw $ʟ_e;
		}
%A%
	}


	public function prepare(): void
	{
%A%
		Nette\Bridges\CacheLatte\CacheMacro::initRuntime($this);
%A%
