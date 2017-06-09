# View-Helpers
Sets of view-renderer helpers.


## In Your Controller Action

```php
$paginator = new \ViewHelper\Paginator(
    new ProviderCallback(
        function($offset, $perPage) {
            return $this->repoPosts->find([], $offset, $perPage);
        },
        function() {
            return $this->repoPosts->count([]);
        }
    ),
    [
        'page_size'     => 20,
        'curr_page_num' => $page,
    ]
);

return [
    'posts'     => $paginator->page(),
    'paginator' => $paginator,
];
```

## In View

```php
\Module\ViewHelpers\Actions::RenderPagination()->withPaginator($paginator)
    ->render('partial/pagination');
```

Template:

```html
// partial/pagination

<div class="col-md-12 text-center">
    <ul class="pagination">

        <li>
            <a href="<?= \Module\HttpFoundation\Actions::url(null, ['page' => $navigator->getPrevious()]) ?>">
                <i class="fa fa-chevron-right"></i>
            </a>
        </li>

        <?php foreach ($navigator->getScrolling() as $page) { ?>
        <li <?= ($page == $navigator->getCurrentPage()) ? 'class="active"' : '' ?> >
            <a href="<?= \Module\HttpFoundation\Actions::url(null, ['page' => $page]) ?>"><?= $page ?></a>
        </li>
        <?php } ?>

        <li>
            <a href="<?= \Module\HttpFoundation\Actions::url(null, ['page' => $navigator->getNext()]) ?>">
                <i class="fa fa-chevron-left"></i>
            </a>
        </li>
    </ul>
</div>
```
