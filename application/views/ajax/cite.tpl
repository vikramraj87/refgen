                <h2>Citations</h2>
                {if is_array($list) == true && count($list) > 0}
                    <ol id="citations">
                        {foreach $list as $article}
                            <li class="clear-fix">{$article->vancouverCitation}
                                <a
                                    {if $mode == "single"}
                                    href="/search/remove/pmid/{$article->pmid}?redirect=/search/display/pmid/{$query}"
                                    {else}
                                    href="/search/remove/pmid/{$article->pmid}?redirect=/search/result/term/{$query}/page/{$page}"
                                    {/if}
                                    data-pmid="{$article->pmid}">
                                    Remove
                                </a>
                            </li>
                        {/foreach}
                    </ol>
                {else}
                    <p>Add references to build a numbered list. Click the "Add to list" link to add the corresponding reference to your collection. Order of the references can be rearranged by dragging and dropping the references.</p>
                {/if}