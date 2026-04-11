var TreanTopTags = {

    loadTags: function(r)
    {
        var loadEl = document.getElementById('loadTags');
        if (loadEl) {
            loadEl.hidden = true;
        }
        var t = document.createElement('ul');
        t.className = 'horde-tags';
        r.tags.forEach(function(tag) {
            if (tag == null) {
                return;
            }
            var item = document.createElement('li');
            item.className = 'treanBookmarkTag';
            item.textContent = tag;
            item.addEventListener('click', function() { TreanTopTags.add(tag); });
            t.appendChild(item);
        });
        var container = document.getElementById('treanBookmarkTopTags');
        container.innerHTML = '';
        container.appendChild(t);
        var wrapper = document.getElementById('treanTopTagsWrapper');
        if (wrapper) {
            wrapper.hidden = false;
        }
    },

    add: function(tag)
    {
        HordeImple.AutoCompleter.treanBookmarkTags.addNewItemNode(tag);
    }

};