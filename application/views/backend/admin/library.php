<style>
    .premium-wrapper { font-family: 'Inter', sans-serif; }
    .premium-card { background: #fff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .page-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 5px; margin-top: 0; }
    .breadcrumb-text { font-size: 13px; color: #64748b; margin-bottom: 20px; }
    .filter-label { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 5px; display: block; }
    .filter-label span { color: #ef4444; }
    .filter-select, .filter-input { border-radius: 6px; border: 1px solid #cbd5e1; height: 42px; width: 100%; padding: 0 12px; font-size: 14px; color: #334155; }
    .btn-action { background: #1e3a8a; color: white; border-radius: 6px; height: 42px; font-weight: 500; font-size: 14px; border: none; padding: 0 20px; transition: 0.2s; }
    .btn-action:hover { background: #172554; color: white; }
    .btn-danger-sm { background: #dc2626; color: white; border: none; border-radius: 4px; padding: 5px 10px; font-size: 12px; }
    .btn-success-sm { background: #16a34a; color: white; border: none; border-radius: 4px; padding: 5px 10px; font-size: 12px; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th, .data-table td { border: 1px solid #e2e8f0; padding: 10px; font-size: 13px; }
    .data-table th { background: #f8fafc; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; }
    .data-table td { color: #334155; }
    .badge-avail { background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-out { background: #fee2e2; color: #b91c1c; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-issued { background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-returned { background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; padding: 20px; color: white; text-align: center; margin-bottom: 20px; }
    .stat-card.green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .stat-card.orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-num { font-size: 28px; font-weight: 800; }
    .stat-label { font-size: 12px; opacity: 0.9; margin-top: 4px; }
    .nav-tabs-custom .nav-link { padding: 10px 20px; font-size: 13px; font-weight: 600; color: #64748b; border: none; border-bottom: 3px solid transparent; }
    .nav-tabs-custom .nav-link.active { color: #1e3a8a; border-bottom-color: #1e3a8a; }
</style>

<div class="premium-wrapper">

<!-- Stats -->
<?php
    $total_books = $this->db->count_all_results('library');
    $issued_count = $this->db->get_where('book_issue', ['status' => 'issued'])->num_rows();
    $overdue = 0;
    $issued_books = $this->db->get_where('book_issue', ['status' => 'issued'])->result();
    foreach ($issued_books as $ib) {
        if (date('Y-m-d') > $ib->due_date) $overdue++;
    }
?>
<div class="row">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-num"><?php echo $total_books; ?></div>
            <div class="stat-label">Total Books</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="stat-num"><?php echo $issued_count; ?></div>
            <div class="stat-label">Currently Issued</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card orange">
            <div class="stat-num"><?php echo $overdue; ?></div>
            <div class="stat-label">Overdue Books</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="premium-card">
            <h2 class="page-title"><i class="fa fa-book" style="color:#667eea;"></i> Library Management</h2>
            <div class="breadcrumb-text">Dashboard &rsaquo; Library</div>

            <!-- Tabs -->
            <ul class="nav nav-tabs nav-tabs-custom" style="margin-bottom:20px; border-bottom: 2px solid #e2e8f0;">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-books">📚 Book Catalog</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-add">➕ Add Book</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-issue">📤 Issue Book</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-issued">📋 Issued Books</a></li>
            </ul>

            <div class="tab-content">
                <!-- TAB: Book Catalog -->
                <div class="tab-pane fade in active" id="tab-books">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th><th>Title</th><th>Author</th><th>ISBN</th><th>Category</th>
                                <th>Qty</th><th>Available</th><th>Rack</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $books = $this->db->get('library')->result_array();
                        $i = 1;
                        foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="font-weight:600;"><?php echo $book['title']; ?></td>
                                <td><?php echo $book['author']; ?></td>
                                <td><code><?php echo $book['isbn']; ?></code></td>
                                <td><?php echo $book['category']; ?></td>
                                <td><?php echo $book['quantity']; ?></td>
                                <td>
                                    <?php if ($book['available'] > 0): ?>
                                        <span class="badge-avail"><?php echo $book['available']; ?> Avail</span>
                                    <?php else: ?>
                                        <span class="badge-out">Out of Stock</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $book['rack_number']; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>admin/library/delete/<?php echo $book['book_id']; ?>"
                                       onclick="return confirm('Delete this book?')"
                                       class="btn-danger-sm"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($books)): ?>
                            <tr><td colspan="9" style="text-align:center; color:#94a3b8; padding:30px;">No books added yet. Use the "Add Book" tab.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- TAB: Add Book -->
                <div class="tab-pane fade" id="tab-add">
                    <?php echo form_open(base_url() . 'admin/library/add'); ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="filter-label">Book Title <span>*</span></label>
                            <input type="text" name="title" class="filter-input" required placeholder="e.g. The Jungle Book">
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">Author</label>
                            <input type="text" name="author" class="filter-input" placeholder="e.g. Rudyard Kipling">
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">ISBN</label>
                            <input type="text" name="isbn" class="filter-input" placeholder="978-0-123456-78-9">
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">Category</label>
                            <select name="category" class="filter-select">
                                <option>General</option><option>Science</option><option>Mathematics</option>
                                <option>History</option><option>Literature</option><option>Reference</option>
                                <option>Comics</option><option>Biography</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-2">
                            <label class="filter-label">Quantity <span>*</span></label>
                            <input type="number" name="quantity" class="filter-input" value="1" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">Rack Number</label>
                            <input type="text" name="rack_number" class="filter-input" placeholder="e.g. A-12">
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label" style="color:transparent;">Action</label>
                            <button type="submit" class="btn-action" style="width:100%;"><i class="fa fa-plus"></i> Add Book</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <!-- TAB: Issue Book -->
                <div class="tab-pane fade" id="tab-issue">
                    <?php echo form_open(base_url() . 'admin/issue_book'); ?>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="filter-label">Select Book <span>*</span></label>
                            <select name="book_id" class="filter-select" required>
                                <option value="">Choose...</option>
                                <?php foreach ($books as $b): ?>
                                    <?php if ($b['available'] > 0): ?>
                                    <option value="<?php echo $b['book_id']; ?>"><?php echo $b['title']; ?> (<?php echo $b['available']; ?> avail)</option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="filter-label">Select Student <span>*</span></label>
                            <select name="student_id" class="filter-select" required>
                                <option value="">Choose...</option>
                                <?php $all_students = $this->db->get('student')->result_array();
                                foreach ($all_students as $st): ?>
                                    <option value="<?php echo $st['student_id']; ?>"><?php echo $st['name']; ?> (<?php echo $st['roll']; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">Due Date <span>*</span></label>
                            <input type="date" name="due_date" class="filter-input" value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label" style="color:transparent;">Action</label>
                            <button type="submit" class="btn-action" style="width:100%;"><i class="fa fa-share"></i> Issue</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <!-- TAB: Issued Books -->
                <div class="tab-pane fade" id="tab-issued">
                    <table class="data-table">
                        <thead>
                            <tr><th>#</th><th>Book</th><th>Student</th><th>Issued</th><th>Due</th><th>Status</th><th>Fine</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                        <?php $issues = $this->db->order_by('issue_id', 'DESC')->get('book_issue')->result_array();
                        $j = 1;
                        foreach ($issues as $issue):
                            $bk = $this->db->get_where('library', ['book_id' => $issue['book_id']])->row();
                            $stud = $this->db->get_where('student', ['student_id' => $issue['student_id']])->row();
                        ?>
                            <tr>
                                <td><?php echo $j++; ?></td>
                                <td style="font-weight:600;"><?php echo $bk ? $bk->title : 'N/A'; ?></td>
                                <td><?php echo $stud ? $stud->name : 'N/A'; ?></td>
                                <td><?php echo $issue['issue_date']; ?></td>
                                <td><?php echo $issue['due_date']; ?></td>
                                <td>
                                    <?php if ($issue['status'] == 'issued'): ?>
                                        <?php if (date('Y-m-d') > $issue['due_date']): ?>
                                            <span class="badge-out">OVERDUE</span>
                                        <?php else: ?>
                                            <span class="badge-issued">Issued</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="badge-returned">Returned</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $issue['fine'] > 0 ? '₹' . $issue['fine'] : '-'; ?></td>
                                <td>
                                    <?php if ($issue['status'] == 'issued'): ?>
                                        <a href="<?php echo base_url(); ?>admin/return_book/<?php echo $issue['issue_id']; ?>"
                                           class="btn-success-sm"><i class="fa fa-check"></i> Return</a>
                                    <?php else: ?>
                                        <span style="color:#94a3b8; font-size:12px;"><?php echo $issue['return_date']; ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($issues)): ?>
                            <tr><td colspan="8" style="text-align:center; color:#94a3b8; padding:30px;">No books have been issued yet.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
