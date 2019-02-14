/*
Adds title to tables

Revision History:

    Created by: Karen Gallego

    2/13/2019:  
        this js is not being used yet, decide later if it should be used

*/
$('table.reflow').find('th').each(function(index, value){

    var $this = $(this),
    title = '<b class="cell-label">' + $this.html() + '</b>';

    // add titles to cells
    $('table.reflow')
    .find('tr').find('td:eq('+index+')').wrapInner('<span class="cell-content"></span>').prepend( title );
});