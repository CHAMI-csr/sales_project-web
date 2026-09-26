<?php include '../include/header.php'; ?>

<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Business Registration</h2>
    <form action="../lib/submit_form.php" method="post" enctype="multipart/form-data">


        <div class="mb-4">
            <label for="bname" class="block text-gray-700 text-sm font-bold mb-2">Business Name:</label>
            <input type="text" id="bname" name="bname" maxlength="30"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Business Registration Date:</label>
            <input type="date" id="date" name="date"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="bnumber" class="block text-gray-700 text-sm font-bold mb-2">Business number:</label>
            <input type="text" id="bnumber" name="bnumber" maxlength="15"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="bregid" class="block text-gray-700 text-sm font-bold mb-2">Business Registration ID:</label>
            <input type="text" id="bregid" name="bregid" maxlength="15"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="blogo" class="block text-gray-700 text-sm font-bold mb-2">Business Registration
                Certificate:</label>
            <input type="file" id="blogo" name="bcertificate" class="w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-violet-50 file:text-violet-700
                       hover:file:bg-violet-100">
        </div>

        <div class="mb-4">
            <label>Business Type:</label><br>
            <input type="checkbox" id="phones" name="btype[]" value="Phones">
            <label for="phones"> Phones</label><br>
            <input type="checkbox" id="backcovers" name="btype[]" value="Back Covers">
            <label for="backcovers"> Back Covers</label><br>
            <input type="checkbox" id="headphones" name="btype[]" value="Headphones">
            <label for="headphones"> Headphones</label><br>
            <input type="checkbox" id="chargers" name="btype[]" value="Chargers">
            <label for="chargers"> Chargers</label>
        </div>

        <div class="mb-4">
            <label for="blogo" class="block text-gray-700 text-sm font-bold mb-2">Business Logo:</label>
            <input type="file" id="blogo" name="blogo" class="w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-violet-50 file:text-violet-700
                       hover:file:bg-violet-100">
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" name="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
                Submit
            </button>
        </div>

    </form>
</div>
<?php


if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'Business_Name':
            $error_message = 'Business name is required!';
            break;
        case 'large_file':
            $error_message = 'File is too large!';
            break;
        case 'invalid_file':
            $error_message = 'Invalid file type!';
            break;
        case 'invalid_image':
            $error_message = 'Invalid image type!';
            break;
        case 'Business_Number':
            $error_message = 'Business number is required!';
            break;
        case 'Business_Reg_ID':
            $error_message = 'Business Registration ID is required!';
            break;
        case 'already_registered':
            $error_message = 'You have already registered your business!';
            break;
        case 'Business_Logo':
            $error_message = 'Business logo is required!';
            break;
        case 'Business_Type':
            $error_message = 'Business type is required!';
            break;
        case 'Business_Certificate':
            $error_message = 'Business registration certificate is required!';
            break;

    }
    $alert_type = 'error';
} elseif (isset($_GET['success'])) {
    $error_message = 'Registration successful!';
    $alert_type = 'success';
}
?>
<div id="alert-container"></div>
<link rel="stylesheet" href="../css/alert.css">

<script>
    function showAlert(type, title, message) {
        const alertContainer = document.getElementById('alert-container');
        const alertElement = document.createElement('div');
        alertElement.className = `alert alert-${type}`;

        let iconSvg;
        switch (type) {
            case 'error':
                iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>`;
                break;
            case 'success':
                iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>`;
                break;
            case 'info':
            default:
                iconSvg = `<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-1 15h2v-2h-2v2zm0-4h2V7h-2v6z"/></svg>`;
                break;
        }

        alertElement.innerHTML = `
            ${iconSvg}
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <div class="alert-message">${message}</div>
            </div>
        `;
        alertContainer.appendChild(alertElement);

        setTimeout(() => {
            alertElement.classList.add('show');
        }, 10);

        setTimeout(() => {
            alertElement.classList.remove('show');
            setTimeout(() => {
                alertElement.remove();
            }, 500);
        }, 5000);
    }

    <?php if ($error_message): ?>
        showAlert('<?php echo $alert_type; ?>', '<?php echo ucfirst($alert_type); ?>', '<?php echo $error_message; ?>');
    <?php endif; ?>
</script>
<script>
     window.onload = function () {
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        url.searchParams.delete('success');
        if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete('error');
            url.searchParams.delete('success');
            window.history.replaceState({ path: url.href }, '', url.href);
        }
    };
</script>

<?php include '../include/footer.php'; ?>