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
        <button id="tab1" class="tab-btn text-text.light.secondary active font-semibold text-sm">General</button>
        <button id="tab2" class="tab-btn text-text.light.secondary font-semibold text-sm">Notifications</button>
        <button id="tab3" class="tab-btn text-text.light.secondary font-semibold text-sm">Change Password</button>
    </nav>

    <div id="tabContent1" class="tab-content content-active">
        <!-- Tab 1 content -->
        <p class="w-full h-80">Content for Tab 1</p>
    </div>
    <div id="tabContent2" class="tab-content">
        <!-- Tab 2 content -->
        <p class="w-full h-80">Content for Tab 2</p>
    </div>
    <div id="tabContent3" class="tab-content">
        <!-- Tab 3 content -->
        <p class="w-full h-80">Content for Tab 3</p>
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
                tabContents.forEach(content => content.classList.remove('content-active'));
                // Add 'active' class to clicked button and corresponding content
                button.classList.add('active');
                const tabContentId = button.getAttribute('id').replace('tab', 'tabContent');
                document.getElementById(tabContentId).classList.add('content-active');
            });
        });
    });
</script>
