now it is time to count number of books and clear when one of the is changed
orderbook
check borrow by bookid and user id
    if yes=> you have given book in borrow
    if no=> go on
check reservation by bookid and userid
    if yes=> you have given book in reservation
    if no=> go on
check for number of books in books
    if>0
        add to booksinborrow, reduce by 1 in books
    if <1
        offer to reserve
reserve:
    check borrow by bookid and user id
        if yes=> you have given book in borrow
        if no=> go on
    check reservation by bookid and userid
        if yes=> you have given book in reservation
        if no=> go on
check for number of books
    if >0
        offer to order
    if = 0 go on with reservation
return:
    remove record from booksinborrow by bookid and userid and get bookid and userid
    increae by 1 in books by bookid

    check if reserved by bookid (other users),
        if yes=> return userid
            remove from reserve by bookid and userid (new)
            add to borrow to first record by userid () and bookid in reservation
            reduce number of books by 1
            remove from reserve by bookid and userid
            update startdate and end date when book atomatically added to borrow
            update enddate when returning the book in borrow and histrory
now think in which case i need to change dates&
    1. When order book=> start and theretical enddates are written
        i use current date for start date and +3weeks end date
    2. When i return book, start date does not change but end date is cahnging.
    The question where: when i return book, book is deleted from ordered book and the only place where info
    about returned book is stored is history
so, i do not need to change dates for oder books, end date should be updated only for history!
So i need funcion to update only enddate in history when return. But return function only deletes
book from oder but does not return borrow_id, so i need
problen when writing book in history: bookid is new=>
    need to make historyid which automatically generated and borrowid which is retrieved during return
OK now end date in history is properly updated

idea is to display startdate and enddate for books in borrow and history.
bookshistory need to plot books with start stop dates


make full testing of all options working
