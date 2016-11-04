function initDataTables (cssselector) {
    $(cssselector).DataTable({
        "order": [[0, 'desc']],
        "language" : {
		    search: "テーブル内検索",
 		    emptyTable: "データがありません。",
		    zeroRecords: "一致するデータがありません。",
		    infoFiltered: "のうち\_TOTAL\_件が一致しました",
		    info: "全\_MAX\_件",
		    infoEmpty: "全\_MAX\_件",
		    paginate : {
			previous: "前",
			next: "次"
		    },
		    lengthMenu : "1ページ内の表示件数： _MENU_"
		}        
    });
    $(cssselector).removeClass("hdn");
}
