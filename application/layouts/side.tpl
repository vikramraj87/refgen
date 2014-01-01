                <h2>Citations</h2>
                {if is_array($list) == true && count($list) > 0}
                	<ol id="citations">
                	{foreach $list as $article}
                    	<li class="clear-fix">{$citation->getCitation($article)}
                            <a  href="/search/remove/pmid/{$article->pmid}?redirect={$smarty.server.REQUEST_URI}" data-pmid="{$article->pmid}">x</a>
                        </li>
                    {/foreach}
                    </ol>
                    <div id="options" class="clearfix">
                        <a href="#" id="export">export</a>
                    </div>
                {else}
                    <ol id="citations"></ol>
                	<p class="replace">Add references to build a numbered list. Click the "Add to list" link to add the corresponding reference to your collection. Order of the references can be rearranged by dragging and dropping the references.</p>
                {/if}
            