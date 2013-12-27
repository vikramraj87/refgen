                <article>
                    <header>
                        <h2>{$article->title}</h2>
                        <h3>{$article->authorsAsCSV|default:"[No Authors Listed]"}</h3>
                    </header>
                    {if empty($article->abstract) != true}
                        {if $short == true}
                            <div class="abstract clearfix">
                                <h3>Abstract</h3>
                                <p class="truncated">{$article->truncatedAbstract}</p>
                                <div class="full" hidden="hidden">
                                    {if count($article->abstract) == 1}
                                        <p>{$article->abstract[0]}</p>
                                    {else}
                                        {foreach $article->abstract as $h => $p}
                                            {if is_string($h) == true}
                                            <h4>{$h}</h4>
                                            {/if}
                                            <p>{$p}</p>
                                        {/foreach}
                                    {/if}
                                </div>
                                {if count($article->abstract) == 1}
                                    {if $article->abstract[0] != $article->truncatedAbstract}
                                <p class="read-more"><a href="/search/display/pmid/{$article->pmid}">read more</a></p>
                                    {/if}
                                {else}
                                    <p class="read-more"><a href="/search/display/pmid/{$article->pmid}">read more</a></p>
                                {/if}
                            </div>
                        {else}
                            <div class="abstract clearfix">
                                <h3>Abstract</h3>
                                {if count($article->abstract) == 1}
                                    <p>{$article->abstract[0]}</p>
                                {else}
                                    {foreach $article->abstract as $h => $p}
                                        {if is_string($h) == true}
                                        <h4>{$h}</h4>
                                        {/if}
                                        <p>{$p}</p>
                                    {/foreach}
                                {/if}
                            </div>
                        {/if}
                    {/if}
                    <footer>
                        <p>{$article->footer}</p>
                        <p class="pmid">PMID: <a href="http://www.ncbi.nlm.nih.gov/pubmed/{$article->pmid}" target="_blank">{$article->pmid}</a></p>
                        <p>Cite by: <span class="citation">{$article->vancouverCitation}</span></p>
                        <p class="add-to-list">
                            <a
                               href="/search/add/pmid/{$article->pmid}?redirect={$smarty.server.REQUEST_URI}"
                               data-pmid="{$article->pmid}">
                               +
                            </a>
                        </p>
                    </footer>
                </article>