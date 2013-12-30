							{foreach $result as $article}
                {include file="article.tpl" short=true article=$article citation=$citation}
                            {/foreach}
                {if $pagination->isRequired()}
                <ol id="pagination">
                	{if $pagination->isFirst()}
                    <li class="page first"><a href="/search/result/term/{$query}/page/1">&lt;&lt;</a></li>
                    {/if}
                    {if $pagination->getPrev()}
                    <li class="page prev"><a href="/search/result/term/{$query}/page/{$pagination->getPrev()}">&lt;</a></li>
                    {/if}
                    {foreach $pagination as $page}
                    <li class="page num">
                    	{if $pagination->getCurrPage() == $page}
                        <span>{$page}</span>
                        {else}
                        <a href="/search/result/term/{$query}/page/{$page}">{$page}</a>
                        {/if}
                 	{/foreach}
                	{if $pagination->getNext()}
                    <li class="page prev"><a href="/search/result/term/{$query}/page/{$pagination->getNext()}">&gt;</a></li>
                    {/if}
 
                </ol>
                {/if}