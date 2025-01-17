import $ from 'jquery';

class MyNotes {
    constructor() {
       this.events();
    }

    events () {
      $('.delete-note').on("click", this.deleteNote);
      $('.edit-note').on("click", this.editNote.bind(this));
      $('.update-note').on("click", this.updateNote.bind(this));
      $(".submit-note").on("click", this.createNote.bind(this))
    }
    // Hàm sửa ghi chú 
    editNote(e) {
      var thisNote = $(e.target).parents("li");
      
      //Hàm xử lý khi click vào nút edit
      if(thisNote.attr("state") == 'editable') {
        //Hàm xử lý khi người click vào nút cancel
        this.cancelEdit(thisNote);
      } else {
        this.editAble(thisNote);

      }
      
    } 
  editAble(thisNote) {
      thisNote.find(".edit-note").html("<i class='fa fa-times' aria-hidden='true'></i> Cancel");
      thisNote.find(".note-title-field,.note-body-field").removeAttr("readonly").addClass("note-active-field");
      thisNote.find(".update-note").addClass("update-note--visible");
      thisNote.attr("state","editable");
    }

  cancelEdit(thisNote) {
      thisNote.find(".edit-note").html("<i class='fa fa-pencil' aria-hidden='true'></i> Edit");
      thisNote.find(".note-title-field,.note-body-field").attr("readonly","readonly").removeClass("note-active-field");
      thisNote.find(".update-note").removeClass("update-note--visible");
      thisNote.attr("state", "cancel");
    }
    //Hàm tương ứng sự kiện nó bắt
    //Hàm cập nhật data vào api 
  updateNote(e) {
    var thisNote = $(e.target).parents("li")

    var ourUpdatedPost = {
      "title": thisNote.find(".note-title-field").val(),
      "content": thisNote.find(".note-body-field").val()
    }

    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
      },
      url: universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.data("id"),
      type: "POST",
      data: ourUpdatedPost,
      success: response => {
        this.cancelEdit(thisNote)
        console.log("Bạn đã update thành công")
        console.log(response)
      },
      error: response => {
        console.log("Sorry")
        console.log(response)
      }
    })
  }

    deleteNote(e) {
    var noteID = $(e.target).parents("li");
      console.log(noteID.attr("data-id"));
      $.ajax({
        beforeSend: (xhr) => {
              xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
        },
        url: "http://university.test/wp-json/wp/v2/note/"+noteID.attr("data-id"),
        method : 'DELETE' ,
        success : () => {
          noteID.slideUp();
        } ,
        error: (error) => {console.log(error)} ,
      })
    }


    //create note
  createNote() {
    var ourNewPost = {
      "title": $(".new-note-title").val(),
      "content": $(".new-note-body").val(),
      "status": "publish"
    }

    $.ajax({
      beforeSend: xhr => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
      },
      url: universityData.root_url + "/wp-json/wp/v2/note/",
      type: "POST",
      data: ourNewPost,
      success: response => {
        console.log(response);
        $(".new-note-title, .new-note-body").val("")
        $(`
          <li data-id="${response.id}">
            <input readonly class="note-title-field" value="${response.title.raw}">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field">${response.content.raw}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
          </li>
          `)
          .prependTo("#my-notes")
          .hide()
          .slideDown()
      },
      error: response => {
        console.log("Sorry")
        console.log(response)
      }
    })
  }
}

export default MyNotes;