

<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('body-class', 'ebook-home'); ?>

<?php $__env->startSection('content'); ?>

    <section class="home-hero">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6">
                    <h1>Explore Our Digital eBook Collection</h1>
                    <p>Access company, brand and industry eBooks in one place.</p>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="#ebooksSection" class="btn btn-info">
                            Browse eBooks &rarr;
                        </a>

                        <?php if($canUploadNow): ?>
                            <button type="button" class="btn btn-outline-info" id="openUploadMetaModal">
                                + Upload PDF
                            </button>
                        <?php endif; ?>
                    </div>

                    <?php if($canUploadNow): ?>
                        <form id="uploadForm" enctype="multipart/form-data">
                            <div class="modal fade" id="uploadMetaModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload eBook</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" id="pdfInput" name="pdfs[]" multiple accept="application/pdf"
                                                hidden>
                                            <input type="file" id="folderInput" name="pdfs[]" webkitdirectory directory
                                                multiple hidden>

                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                <button type="button" class="btn btn-outline-primary" id="selectFiles">
                                                    Select PDF(s)
                                                </button>
                                                <button type="button" class="btn btn-outline-primary" id="selectFolder">
                                                    Select Folder
                                                </button>
                                            </div>

                                            <div id="fileList" class="border rounded p-3 mb-3" style="display:none;">
                                                <strong>Selected Files (<span id="fileCount">0</span>)</strong>
                                                <ul id="fileItems" class="mb-0 mt-2"></ul>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Ebook Name</label>
                                                <input type="text" name="ebook_name" class="form-control"
                                                    placeholder="Enter eBook name" required>
                                            </div>

                                            <div class="mb-3" id="uploadCategoryField">
                                                <label class="form-label fw-semibold">Category</label>
                                                <select name="category_id" id="uploadCategorySelect" class="form-select" required>
                                                    <option value="">Select Category</option>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="mb-3" id="uploadSubCategoryField" style="display:none;">
                                                <label class="form-label fw-semibold">Sub Category</label>
                                                <select name="subcategory_id" id="uploadSubCategorySelect" class="form-select">
                                                    <option value="">Select Subcategory</option>
                                                </select>
                                            </div>

                                            <div class="mb-3" id="uploadRelatedSubCategoryField" style="display:none;">
                                                <label class="form-label fw-semibold">Related Sub Category</label>
                                                <select name="related_subcategory_id" id="uploadRelatedSubCategorySelect"
                                                    class="form-select">
                                                    <option value="">Select Related Subcategory</option>
                                                </select>
                                            </div>

                                            <div id="uploadStatus" class="upload-status mt-3" style="display:none;">
                                                <span class="spinner"></span>
                                                <span class="text">Uploading ebook... Please wait</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-info">Upload & Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>

                <div class="col-lg-6 text-center">
                    <img src="<?php echo e(asset('images/homepage.png')); ?>" alt="Hero">
                </div>

            </div>
        </div>
    </section>

    <div class="container mt-5" id="ebooksSection">

        <div class="home-toolbar mb-5">
            <form class="row g-3" method="GET" action="<?php echo e(url('/home')); ?>" id="ebookFilterForm">

                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search ebooks..."
                        value="<?php echo e(request('search')); ?>">
                </div>

                <div class="col-md-3">
                    <select class="form-control" name="category" id="categorySelect" data-cascade-mode="filter">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php if($selectedCategoryId == $category->id): echo 'selected'; endif; ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3" id="subCategoryField"
                    style="<?php echo e($subcategories->isNotEmpty() || $selectedSubcategoryId ? '' : 'display:none;'); ?>">
                    <select class="form-control" name="subcategory" id="subCategorySelect"
                        data-selected="<?php echo e($selectedSubcategoryId); ?>">
                        <option value="">All Sub Categories</option>
                        <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($subcategory->id); ?>" <?php if($selectedSubcategoryId == $subcategory->id): echo 'selected'; endif; ?>>
                                <?php echo e($subcategory->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3" id="relatedSubCategoryField"
                    style="<?php echo e($relatedSubcategories->isNotEmpty() || $selectedRelatedSubcategoryId ? '' : 'display:none;'); ?>">
                    <select class="form-control" name="related_subcategory" id="relatedSubCategorySelect"
                        data-selected="<?php echo e($selectedRelatedSubcategoryId); ?>">
                        <option value="">All Related Sub Categories</option>
                        <?php $__currentLoopData = $relatedSubcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedSubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($relatedSubcategory->id); ?>"
                                <?php if($selectedRelatedSubcategoryId == $relatedSubcategory->id): echo 'selected'; endif; ?>>
                                <?php echo e($relatedSubcategory->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-12 col-lg-2">
                    <button class="btn btn-dark w-100" type="submit">
                        Filter
                    </button>
                </div>

                <div class="col-md-12 col-lg-2">
                    <a href="<?php echo e(url('/home')); ?>" class="btn btn-outline-secondary w-100" id="clearFilterBtn">
                        Clear Filter
                    </a>
                </div>

            </form>
        </div>


        
        <div id="ebookResults">
            <div class="row">
                <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $coverPath = optional($book->coverPage)->image_path;
                        $coverUrl = $coverPath
                            ? asset(ltrim(str_replace('\\', '/', $coverPath), '/'))
                            : asset('images/homecover.png');
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-5 text-center">

                        <div class="book-wrapper">
                            <div class="book">
                                <img src="<?php echo e($coverUrl); ?>" alt="<?php echo e($book->title); ?> cover">
                            </div>

                            <div class="book-actions" aria-label="Book actions">
                                <a href="/ebook/view/<?php echo e($book->id); ?>" class="book-action-btn" title="Preview">
                                    <i class="bi bi-eye"></i>
                                    <span>Preview</span>
                                </a>

                                <?php if($canShareNow): ?>
                                    <button type="button" class="book-action-btn share-action-btn"
                                        onclick="openShareModal(<?php echo e($book->id); ?>)" title="Share">
                                        <i class="bi bi-share"></i>
                                        <span>Share</span>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <div class="book-info">
                                <h6><?php echo e($book->title); ?></h6>
                                <small><?php echo e($book->created_at?->format('d M Y')); ?></small>
                            </div>
                        </div>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center">
                        <p>No eBooks found.</p>
                    </div>
                <?php endif; ?>

            </div>

            <div class="mt-3">
                <?php echo e($ebooks->withQueryString()->links('pagination::bootstrap-5')); ?>

            </div>
        </div>

    </div>

    <div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share Ebook</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="shareLinkInput" class="form-control" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="copyShareLink()">Copy Link</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canShareNow = <?php echo json_encode((bool) $canShareNow, 15, 512) ?>;
            if (!canShareNow) {
                document.querySelectorAll('.share-action-btn').forEach((btn) => btn.remove());
            }

            const uploadForm = document.getElementById('uploadForm');
            const openModalBtn = document.getElementById('openUploadMetaModal');
            const uploadModalEl = document.getElementById('uploadMetaModal');

            const categorySelect = document.getElementById('uploadCategorySelect');
            const subCategorySelect = document.getElementById('uploadSubCategorySelect');
            const relatedSubCategorySelect = document.getElementById('uploadRelatedSubCategorySelect');

            const subCategoryField = document.getElementById('uploadSubCategoryField');
            const relatedSubCategoryField = document.getElementById('uploadRelatedSubCategoryField');

            if (!uploadForm || !openModalBtn || !uploadModalEl || !categorySelect || !subCategorySelect) return;

            const uploadModal = new bootstrap.Modal(uploadModalEl);

            const toggleField = (field, show) => {
                if (!field) return;
                field.style.display = show ? '' : 'none';
            };

            const resetSubCategories = () => {
                subCategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            };

            const resetRelatedSubCategories = () => {
                if (!relatedSubCategorySelect) return;
                relatedSubCategorySelect.innerHTML = '<option value="">Select Related Subcategory</option>';
            };

            const loadChildren = (parentId, targetSelect, placeholder) => {
                targetSelect.innerHTML = `<option value="">${placeholder}</option>`;

                if (!parentId) return Promise.resolve([]);

                return fetch('/get-subcategories/' + encodeURIComponent(parentId), {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {
                            Accept: 'application/json'
                        }
                    })
                    .then((res) => res.json())
                    .then((items) => {
                        if (!Array.isArray(items)) return [];

                        items.forEach((item) => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.name;
                            targetSelect.appendChild(option);
                        });

                        return items;
                    })
                    .catch(() => []);
            };

            openModalBtn.addEventListener('click', function() {
                uploadModal.show();
            });

            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;

                resetSubCategories();
                resetRelatedSubCategories();
                toggleField(relatedSubCategoryField, false);
                subCategorySelect.required = false;
                if (relatedSubCategorySelect) {
                    relatedSubCategorySelect.required = false;
                }

                if (!categoryId) {
                    toggleField(subCategoryField, false);
                    return;
                }

                loadChildren(categoryId, subCategorySelect, 'Select Subcategory').then((items) => {
                    const hasItems = items.length > 0;
                    toggleField(subCategoryField, hasItems);
                    subCategorySelect.required = hasItems;
                });
            });

            subCategorySelect.addEventListener('change', function() {
                const subCategoryId = this.value;
                if (!relatedSubCategorySelect) return;

                resetRelatedSubCategories();
                relatedSubCategorySelect.required = false;

                if (!subCategoryId) {
                    toggleField(relatedSubCategoryField, false);
                    return;
                }

                loadChildren(subCategoryId, relatedSubCategorySelect, 'Select Related Subcategory').then((items) => {
                    const hasItems = items.length > 0;
                    toggleField(relatedSubCategoryField, hasItems);
                    relatedSubCategorySelect.required = hasItems;
                });
            });
        });

        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ebook\resources\views/ebook/home.blade.php ENDPATH**/ ?>