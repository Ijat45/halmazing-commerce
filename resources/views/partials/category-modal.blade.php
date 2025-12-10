<!-- All Categories Modal -->
<div class="modal fade" id="allCategoriesModal" tabindex="-1" aria-labelledby="allCategoriesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="allCategoriesModalLabel">All Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row text-center g-3">
                    @foreach ($allCategories ?? [] as $category)
                        @php
                            $isActive = false;
                            if (isset($product) && $product->categories) {
                                $isActive = $product->categories->contains('id', $category->id);
                            }
                        @endphp
                        <div class="col-4">
                            <x-buttons.category :icon="$category->icon" :label="$category->name" :isActive="$isActive" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>