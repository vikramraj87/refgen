                <article>
                    <header>
                        <h2>{$article->title}</h2>
                        {if empty($article->authors) == true}
                        <h3>[No authors listed]</h3>
                        {else}
                        <h3>{implode(", ", $article->authors)}</h3>
                        {/if}
                    </header>
                    {if empty($article->abstract) != true}
                    <div class="abstract clearfix">
                        <h3>Abstract</h3>
                        {if $short === true}
                        <p class="truncated">{$article->truncatedAbstract}</p>
                            {if (count($article->abstract) === 1 &&
                                strlen($article->abstract[0]) > 300) ||
                                    count($article->abstract) > 1}
                        <div class="full" hidden="hidden">
                                {if count($article->abstract) > 1}
                                    {foreach $article->abstract as $h => $p}
                                        {if is_string($h) == true}
                            <h4>{$h}</h4>
                                        {/if}
                            <p>{$p}</p>
                                    {/foreach}
                                {else}
                            <p>{$article->abstract[0]}</p>
                                {/if}
                        </div>
                        <p class="read-more"><a href="/search/display/pmid/{$article->pmid}">read more</a></p
                            {/if}
                        {else}
                            {if count($article->abstract) > 1}
                                {foreach $article->abstract as $h => $p}
                                    {if is_string($h) == true}
                    <h4>{$h}</h4>
                                    {/if}
                    <p>{$p}</p>
                                {/foreach}
                            {elseif count($article->abstract) == 1}
                    <p>{$article->abstract[0]}</p>
                            {/if}
                        {/if}
                    </div>
                    {/if}
                    <footer>
                        <p class="pmid">PMID: <a href="http://www.ncbi.nlm.nih.gov/pubmed/{$article->pmid}" target="_blank">{$article->pmid}</a></p>
                        <p>Cite by: <span class="citation">{$citation->getCitation($article)}</span></p>
                        <p class="add-to-list">
                            <a href="/search/add/pmid/{$article->pmid}?redirect={$smarty.server.REQUEST_URI}" data-pmid="{$article->pmid}">+</a>
                        </p>
                    </footer>
                </article>