<div class="relative" style="background: #F02D00" id="card">
    <div class="container mx-auto py-4 flex justify-between items-center text-white">
        <p class="font-bold text-2xl ">
            All syllabus 144,000đ
        </p>
        <ul class="flex gap-1">
            <li class="text-center">
                <p class="font-bold text-3xl" id='hours'>00</p>
                <p class="font-normal text-xs">hours</p>
            </li>
            <div class="py-1">
                •
            </div>
            <li class="text-center">
                <p class="font-bold text-3xl" id='mins'>00</p>
                <p class="font-normal text-xs">mins</p>
            </li>
            <div class="py-1">
                •
            </div>
            <li class="text-center">
                <p class="font-bold text-3xl" id='secs'>00</p>
                <p class="font-normal text-xs">secs</p>
            </li>
        </ul>
    </div>
    <button class="absolute right-4 top-1/2 transform -translate-y-1/2" id='closeBtn'>
        <span class="text-white">
            x
        </span>
    </button>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownH = document.getElementById('hours');
        const countdownM = document.getElementById('mins');
        const countdownS = document.getElementById('secs');

        const currentDate = new Date();
            // Set the countdown date to the next occurrence of a specific hour
        const targetHour = 14; // Set the target hour (24-hour format, e.g., 18 for 6 PM)
        let countdownDate = new Date(currentDate); // Clone the current date
        countdownDate.setHours(targetHour, 0, 0, 0);

        // If the target hour has already passed for today, set the countdown to the next day
        if (currentDate.getHours() >= targetHour) {
            countdownDate.setDate(currentDate.getDate() + 1);
        }
        // Update the countdown every second
        const countdownInterval = setInterval(function() {
            // Get the current date and time
            const now = new Date().getTime();

            // Calculate the remaining time
            const timeRemaining = countdownDate - now;
            // Calculate days, hours, minutes, and seconds
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            // Display the countdown
            countdownH.textContent = hours <= 10 ? "0" + hours : hours
            countdownM.textContent = minutes <= 10 ? "0" + minutes : minutes
            countdownS.textContent = seconds < 10 ? "0" + seconds : seconds

            // If the countdown is over, stop the timer
            if (timeRemaining < 0) {
                clearInterval(countdownInterval);
            }
        }, 1000);
    });

    document.getElementById('closeBtn').addEventListener('click', function() {
        var content = document.getElementById('card');
        content.style.display = (content.style.display === 'none') ? 'block' : 'none';
    });
</script>
