<!-- Bootstrap CSS -->
<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous" />
<!-- Bootstrap Icons -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

<!-- Put all component styles here -->

<?php
// Determine if in  root directory or a subdirectory
$baseDir = '';
if (strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false) {
    $baseDir = '../';
}
?>

<link rel="stylesheet" href="<?php echo $baseDir; ?>styles/header.css">
<link rel="stylesheet" href="<?php echo $baseDir; ?>styles/footer.css">

<!-- Nothing below the footer! -->

<?php
function placeHeader()
{
    require getAbsPath() . '/../components/header.html';
}

function placeFooter()
{
    require getAbsPath() . '/../components/footer.html';
}

function getAbsPath()
{
    return __DIR__;
}

?>