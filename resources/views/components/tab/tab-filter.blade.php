<style>
    .tab-btn {
        padding: 10px 12px;
        cursor: pointer;
    }

    .tab-btn:hover {
        border-color: #e2e8f0;
    }

    .active {
        border-color: #e2e8f0;
        border-bottom: 2px solid #032482;
        color: #212B36
    }

    .tab-content {
        display: none;
    }

    .tab-content.content-active {
        display: block;
    }
</style>

<div class="rounded-3xl bg-white">
    <nav class="rounded-t-3xl flex border-b border-gray-300 px-6">
        <button id="tab1" data-="all" class="tab-btn text-text.light.secondary  active font-semibold text-sm">All</button>
        <button id="tab2" data-="progress" class="tab-btn text-text.light.secondary font-semibold text-sm">In Progress</button>
        <button id="tab3" data-="completed" class="tab-btn text-text.light.secondary font-semibold text-sm">Completed</button>
    </nav>

    <div id="tabContent1" class="tab-content content-active">
        <!-- Tab 1 content -->
        <div class="w-full h-80">
            <div class="p-12">
                <x-input.dropdown/>
            </div>

        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove 'active' class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                const filter = button.getAttribute('data-')
                // Add 'active' class to clicked button and corresponding content
                button.classList.add('active');
                const tabContentId = button.getAttribute('id').replace('tab', 'tabContent');
                console.log(filter)
                // TODO: Get data based on filter value
            });
        });
    });
</script>
