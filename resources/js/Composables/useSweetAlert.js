import Swal from 'sweetalert2';

/**
 * Custom composable to trigger a premium Tailwind-styled SweetAlert delete confirmation.
 * @param {Object} options - Override defaults (title, text, icon, confirmButtonText, cancelButtonText, etc.)
 * @returns {Promise} Swal.fire response promise
 */
export const useConfirmDelete = (options = {}) => {
    return Swal.fire({
        title: options.title || 'Are you sure?',
        text: options.text || 'This action cannot be undone.',
        icon: options.icon || 'warning',
        showCancelButton: true,
        confirmButtonText: options.confirmButtonText || 'Yes, delete it',
        cancelButtonText: options.cancelButtonText || 'Cancel',
        buttonsStyling: false,
        customClass: {
            popup: 'bg-white dark:bg-[#121212] rounded-2xl border border-gray-200 dark:border-gray-800 shadow-2xl',
            title: 'text-gray-900 dark:text-white font-bold text-xl',
            htmlContainer: 'text-gray-500 dark:text-gray-400',
            actions: 'gap-3',
            confirmButton: 'px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors',
            cancelButton: 'px-4 py-2 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors'
        },
        ...options
    });
};
