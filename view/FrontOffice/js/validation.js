// Fonctions de validation réutilisables
const Validation = {
    validatePublication: function(content) {
        const errors = [];
        
        if (!content || content.trim() === '') {
            errors.push('Please enter some content for your post.');
        } else {
            if (content.trim().length < 2) {
                errors.push('Post content must be at least 2 characters long.');
            }
        }
        
        return {
            isValid: errors.length === 0,
            errors: errors
        };
    },
    
    validateComment: function(content) {
        const errors = [];
        
        if (!content || content.trim() === '') {
            errors.push('Please enter a comment.');
        } else {
            if (content.trim().length < 2) {
                errors.push('Comment must be at least 2 characters long.');
            }
        }
        
        return {
            isValid: errors.length === 0,
            errors: errors
        };
    },
    
    showErrors: function(errorElement, errors) {
        if (errors.length > 0) {
            errorElement.html(errors.join('<br>')).show();
        } else {
            errorElement.hide();
        }
    }
};