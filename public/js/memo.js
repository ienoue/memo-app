function deleteMemo(event) {
    if(window.confirm('メモを削除してもよろしいですか')) {
        document.deleteForm.submit();
    }
}