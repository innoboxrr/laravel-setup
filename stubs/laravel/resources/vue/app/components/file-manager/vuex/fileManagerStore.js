export default {

    namespaced: true,

    state() {
        return {
            asideMobilePanelOpen: false,

            currentDirectory: '',
            paths: [],

            files: [],
            file: null,
            selectedFiles: [], // Para operaciones masivas

            // Modal statuses
            createDirectoryModalOpen: false,
            uploadFilesModalOpen: false,
        };
    },

    getters: {
        
        getCurrentDirectory: state => state.currentDirectory,
        
        getPaths: state => state.paths,
        
        getFiles: state => state.files,
        
        getFile: state => state.file,
        
        getSelectedFiles: state => state.selectedFiles,
        
        getSelectedFilesCount: state => state.selectedFiles.length,

        getSelectedFilesKeys: state => state.selectedFiles.map(file => file.key),

    },

    mutations: {

        SET_CURRENT_DIRECTORY(state, directory) {
            state.currentDirectory = directory;
        },

        PUSH_DIRECTORY(state, directory) {
            state.paths.push(directory);
            state.currentDirectory = state.paths.join('/');
        },

        SET_PATHS(state, paths) {
            state.paths = paths;
        },

        SET_FILES(state, files) {
            state.files = files;
        },

        SET_FILE(state, file) {
            state.file = file;
        },

        SET_SELECTED_FILES(state, selectedFiles) {
            state.selectedFiles = selectedFiles;
        },

        ADD_FILE(state, file) {
            state.files.push(file);
        },

        REMOVE_FILE(state, fileKey) {
            state.files = state.files.filter(file => file.key !== fileKey);
        },

        UPDATE_FILE_VISIBILITY(state, { fileKey, visibility }) {
            const file = state.files.find(file => file.key === fileKey);
            if (file) {
                file.visibility = visibility;
            }
        },

        TOGGLE_ASIDE_MOBILE_PANEL(state) {
            state.asideMobilePanelOpen = !state.asideMobilePanelOpen;
        },

        OPEN_CREATE_DIRECTORY_MODAL(state) {
            state.createDirectoryModalOpen = true;
        },

        CLOSE_CREATE_DIRECTORY_MODAL(state) {
            state.createDirectoryModalOpen = false;
        },

        OPEN_UPLOAD_FILES_MODAL(state) {
            state.uploadFilesModalOpen = true;
        },

        CLOSE_UPLOAD_FILES_MODAL(state) {
            state.uploadFilesModalOpen = false;
        },

    },

    actions: {

        async initFileManager({ state, dispatch }) {
            await dispatch('fetchFiles', state.currentDirectory);
        },

        async fetchFiles({ state, commit }, directory) {
            try {
                const url = route('afm.file_manager.index'); 
                const res = await this.$httpRequest('GET', url, { directory });
                commit('SET_FILES', res.files);
                commit('SET_FILE', res.currentFile);
                commit('SET_SELECTED_FILES', []);
            } catch (error) {
                console.error('Error fetching files:', error);
            }
        },

        async createDirectory({ dispatch, state, commit }, directory) {
            try {
                directory = state.currentDirectory + '/' + directory;
                const url = route('afm.file_manager.create-directory'); 
                await this.$httpRequest('POST', url, { directory });
                dispatch('fetchFiles', state.currentDirectory); 
            } catch (error) {
                console.error('Error creating directory:', error);
            }
        },

        async pushDirectory({ state, commit, dispatch }, directory) {
            commit('PUSH_DIRECTORY', directory);
            await dispatch('changeDirectory', state.currentDirectory);
        },

        async setDirectoryFromPathIndex({ state, commit, dispatch }, index) {
            const directory = index === 0 ? '' : index === 1 ? state.paths[0] : state.paths.slice(0, index).join('/');
            commit('SET_CURRENT_DIRECTORY', directory);
            await dispatch('fetchFiles', directory);
            // Eliminar los directorios que siguen
            if (index === 0) {
                commit('SET_PATHS', []);
            } else {
                commit('SET_PATHS', state.paths.slice(0, index));
            }
        },    

        async changeDirectory({ commit, dispatch }, directory) {
            commit('SET_CURRENT_DIRECTORY', directory);
            await dispatch('fetchFiles', directory);
        },

        async uploadFiles({ state, dispatch }, { files, privacy }) {
            const formData = new FormData();
            files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });
            formData.append('directory', state.currentDirectory);
            formData.append('privacy', privacy); 
        
            try {
                const url = route('afm.file_manager.upload'); 
                const response = await this.$httpRequest('POST', url, formData, {
                    'Content-Type': 'multipart/form-data',
                });
                dispatch('fetchFiles', state.currentDirectory);
            } catch (error) {
                console.error('Error uploading files:', error);
            }
        },       

        async deleteFile({ commit }, fileKey) {
            try {
                const url = route('afm.file.delete'); 
                await this.$httpRequest('POST', url, { file: fileKey });
                commit('REMOVE_FILE', fileKey);
            } catch (error) {
                console.error('Error deleting file:', error);
            }
        },

        async deleteDirectory({ commit }, directory) {
            // PENDING: Implement this
            try {
                const url = route('afm.file_manager.delete-directory'); 
                await this.$httpRequest('POST', url, { directory });
            } catch (error) {
                console.error('Error deleting directory:', error);
            }
        },

        async changeFileVisibility({ commit }, { fileKey, visibility }) {
            try {
                const url = route('afm.file.change-visibility'); 
                await this.$httpRequest('POST', url, { file: fileKey, visibility });
                commit('UPDATE_FILE_VISIBILITY', { fileKey, visibility });
            } catch (error) {
                console.error('Error changing file visibility:', error);
            }
        },
    }
};